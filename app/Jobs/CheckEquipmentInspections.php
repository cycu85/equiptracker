<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\Tool;
use App\Models\HeightEquipment;
use App\Models\ITEquipment;
use App\Models\User;
use App\Mail\EquipmentInspectionDue;

class CheckEquipmentInspections implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public function handle(): void
    {
        $this->checkToolInspections();
        $this->checkHeightEquipmentInspections();
        $this->checkITEquipmentInspections();
    }

    private function checkToolInspections(): void
    {
        $tools = Tool::whereNotNull('next_inspection_date')
            ->where('next_inspection_date', '<=', now()->addDays(30))
            ->where('status', '!=', 'retired')
            ->get();

        if ($tools->isNotEmpty()) {
            $this->sendInspectionNotification($tools, 'tool');
        }
    }

    private function checkHeightEquipmentInspections(): void
    {
        $equipment = HeightEquipment::whereNotNull('next_inspection_date')
            ->where('next_inspection_date', '<=', now()->addDays(30))
            ->where('status', '!=', 'retired')
            ->get();

        if ($equipment->isNotEmpty()) {
            $this->sendInspectionNotification($equipment, 'height_equipment');
        }
    }

    private function checkITEquipmentInspections(): void
    {
        $equipment = ITEquipment::whereNotNull('next_inspection_date')
            ->where('next_inspection_date', '<=', now()->addDays(30))
            ->where('status', '!=', 'retired')
            ->get();

        if ($equipment->isNotEmpty()) {
            $this->sendInspectionNotification($equipment, 'it_equipment');
        }
    }

    private function sendInspectionNotification($equipment, string $type): void
    {
        $mail = new EquipmentInspectionDue($equipment, $type);

        // Wyślij do administratorów i managerów
        $recipients = User::whereIn('role', ['admin', 'manager'])
            ->whereNotNull('email')
            ->pluck('email')
            ->toArray();

        foreach ($recipients as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($email)->send($mail);
            }
        }
    }
}
