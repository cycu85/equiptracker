<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\Transfer;
use App\Models\User;
use App\Mail\TransferCreated;
use App\Mail\TransferReturned;

class SendTransferNotification implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public Transfer $transfer;
    public string $type;
    public array $recipients;

    public function __construct(Transfer $transfer, string $type, array $recipients = [])
    {
        $this->transfer = $transfer;
        $this->type = $type;
        $this->recipients = $recipients;
    }

    public function handle(): void
    {
        $mailClass = match($this->type) {
            'created' => TransferCreated::class,
            'returned' => TransferReturned::class,
            default => null
        };

        if (!$mailClass) {
            return;
        }

        $mail = new $mailClass($this->transfer);

        // Jeśli nie podano odbiorców, wyślij do domyślnych adresów
        if (empty($this->recipients)) {
            $this->recipients = $this->getDefaultRecipients();
        }

        foreach ($this->recipients as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($email)->send($mail);
            }
        }
    }

    private function getDefaultRecipients(): array
    {
        $recipients = [];

        // Dodaj email pracownika jeśli ma
        if ($this->transfer->employee && $this->transfer->employee->email) {
            $recipients[] = $this->transfer->employee->email;
        }

        // Dodaj administratorów systemu
        $admins = User::where('role', 'admin')->whereNotNull('email')->pluck('email')->toArray();
        $recipients = array_merge($recipients, $admins);

        // Dodaj managerów działu
        $managers = User::where('role', 'manager')->whereNotNull('email')->pluck('email')->toArray();
        $recipients = array_merge($recipients, $managers);

        return array_unique($recipients);
    }
}
