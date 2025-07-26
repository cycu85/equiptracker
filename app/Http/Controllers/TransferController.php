<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Models\Employee;
use App\Models\Tool;
use App\Models\HeightEquipment;
use App\Models\ITEquipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $transfers = Transfer::with(['toEmployee', 'fromEmployee', 'creator'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('transfers.index', compact('transfers'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->orderBy('last_name')->get();
        $tools = Tool::where('status', 'available')->orderBy('name')->get();
        $heightEquipment = HeightEquipment::where('status', 'available')->orderBy('name')->get();
        $itEquipment = ITEquipment::where('status', 'available')->orderBy('name')->get();

        return view('transfers.create', compact('employees', 'tools', 'heightEquipment', 'itEquipment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_type' => 'required|in:tool,height_equipment,it_equipment',
            'item_id' => 'required|integer',
            'from_employee_id' => 'nullable|exists:employees,id',
            'to_employee_id' => 'required|exists:employees,id',
            'transfer_date' => 'required|date',
            'return_date' => 'nullable|date|after:transfer_date',
            'reason' => 'nullable|string',
            'condition_notes' => 'nullable|string',
            'status' => 'required|in:active,returned,permanent',
        ]);

        // Generate unique transfer number
        $transferNumber = 'TR' . date('Y') . str_pad(Transfer::count() + 1, 4, '0', STR_PAD_LEFT);

        $transfer = Transfer::create([
            'transfer_number' => $transferNumber,
            'item_type' => $request->item_type,
            'item_id' => $request->item_id,
            'from_employee_id' => $request->from_employee_id,
            'to_employee_id' => $request->to_employee_id,
            'created_by' => Auth::id(),
            'transfer_date' => $request->transfer_date,
            'return_date' => $request->return_date,
            'reason' => $request->reason,
            'condition_notes' => $request->condition_notes,
            'status' => $request->status,
        ]);

        // Update item status
        $this->updateItemStatus($request->item_type, $request->item_id, 'in_use');

        // Wyślij powiadomienie email
        \App\Jobs\SendTransferNotification::dispatch($transfer, 'created');

        return redirect()->route('transfers.show', $transfer)
            ->with('success', 'Protokół przekazania został utworzony pomyślnie.');
    }

    public function show(Transfer $transfer)
    {
        $transfer->load(['toEmployee', 'fromEmployee', 'creator']);
        return view('transfers.show', compact('transfer'));
    }

    public function generatePdf(Transfer $transfer)
    {
        $transfer->load(['toEmployee', 'fromEmployee', 'creator']);
        
        $pdf = Pdf::loadView('transfers.pdf', compact('transfer'));
        
        // Save PDF path
        $filename = 'transfer_' . $transfer->transfer_number . '.pdf';
        $path = 'transfers/' . $filename;
        
        // Create directory if it doesn't exist
        if (!file_exists(storage_path('app/public/transfers'))) {
            mkdir(storage_path('app/public/transfers'), 0755, true);
        }
        
        $pdf->save(storage_path('app/public/' . $path));
        
        // Update transfer with PDF path
        $transfer->update(['pdf_path' => $path]);
        
        return $pdf->download($filename);
    }

    public function return(Transfer $transfer)
    {
        if ($transfer->status !== 'active') {
            return back()->with('error', 'Tylko aktywne przekazania można zwrócić.');
        }

        $transfer->update([
            'status' => 'returned',
            'return_date' => now(),
        ]);

        // Update item status back to available
        $this->updateItemStatus($transfer->item_type, $transfer->item_id, 'available');

        // Wyślij powiadomienie email o zwrocie
        \App\Jobs\SendTransferNotification::dispatch($transfer, 'returned');

        return redirect()->route('transfers.show', $transfer)
            ->with('success', 'Przedmiot został zwrócony pomyślnie.');
    }

    protected function updateItemStatus($itemType, $itemId, $status)
    {
        switch ($itemType) {
            case 'tool':
                Tool::find($itemId)->update(['status' => $status]);
                break;
            case 'height_equipment':
                HeightEquipment::find($itemId)->update(['status' => $status]);
                break;
            case 'it_equipment':
                ITEquipment::find($itemId)->update(['status' => $status]);
                break;
        }
    }
}
