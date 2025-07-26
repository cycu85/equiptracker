<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckEquipmentInspections;

class SendInspectionNotifications extends Command
{
    protected $signature = 'equiptracker:check-inspections';
    protected $description = 'Sprawdza terminy przeglądów sprzętu i wysyła powiadomienia';

    public function handle()
    {
        $this->info('Sprawdzanie terminów przeglądów sprzętu...');
        
        CheckEquipmentInspections::dispatch();
        
        $this->info('Powiadomienia o przeglądach zostały wysłane.');
        
        return Command::SUCCESS;
    }
}
