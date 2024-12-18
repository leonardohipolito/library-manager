<?php

namespace App\Observers;

use App\Enums\LoanStatus;
use App\Models\Loan;

class LoanObserver
{
    /**
     * Handle the Loan "updating" event.
     */
    public function updating(Loan $loan): void
    {
        if ($loan->status == LoanStatus::returned) {
            $loan->returned_at = now();

            return;
        }
        $loan->returned_at = null;
    }
}
