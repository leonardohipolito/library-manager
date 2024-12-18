<?php

use App\Enums\LoanStatus;
use App\Models\Loan;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('check:overdue', function () {
    $this->comment('Checking overdue tasks');
    Loan::where('expires_at', '<', now())
        ->whereNull('returned_at')
        ->update(['status' => LoanStatus::overdue]);
    $this->comment('Done');
})->purpose('Check all overdue loans')->hourly();
