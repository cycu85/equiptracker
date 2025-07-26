<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class EquipmentInspectionDue extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Collection $equipment;
    public string $equipmentType;

    public function __construct(Collection $equipment, string $equipmentType)
    {
        $this->equipment = $equipment;
        $this->equipmentType = $equipmentType;
    }

    public function envelope(): Envelope
    {
        $typeName = $this->getTypeName();
        return new Envelope(
            subject: '[EquipTracker] Przypomnienie o przeglądzie - ' . $typeName,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.equipment-inspection-due',
            with: [
                'equipment' => $this->equipment,
                'equipmentType' => $this->equipmentType,
                'typeName' => $this->getTypeName()
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }

    private function getTypeName(): string
    {
        return match($this->equipmentType) {
            'tool' => 'Narzędzia',
            'height_equipment' => 'Sprzęt wysokościowy',
            'it_equipment' => 'Sprzęt IT',
            default => 'Sprzęt'
        };
    }
}
