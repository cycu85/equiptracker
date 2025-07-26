<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Transfer;

class TransferCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Transfer $transfer;

    public function __construct(Transfer $transfer)
    {
        $this->transfer = $transfer;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[EquipTracker] Nowy transfer sprzętu - ' . $this->transfer->equipment_type,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.transfer-created',
            with: [
                'transfer' => $this->transfer,
                'employee' => $this->transfer->employee,
                'equipment' => $this->getEquipmentDetails()
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }

    private function getEquipmentDetails()
    {
        switch ($this->transfer->equipment_type) {
            case 'tool':
                return $this->transfer->tool;
            case 'height_equipment':
                return $this->transfer->heightEquipment;
            case 'it_equipment':
                return $this->transfer->itEquipment;
            default:
                return null;
        }
    }
}
