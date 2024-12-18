<?php

namespace App\Models;

use App\Enums\LoanStatus;
use App\Observers\LoanObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(LoanObserver::class)]
class Loan extends Model
{
    /** @use HasFactory<\Database\Factories\LoanFactory> */
    use HasFactory;

    protected $fillable = [
        'expires_at',
        'returned_at',
        'status',
    ];

    protected function casts()
    {
        return [
            'expires_at' => 'date',
            'returned_at' => 'date',
            'status' => LoanStatus::class,
        ];
    }

    /** @return BelongsTo<Book, Loan>  */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /** @return BelongsTo<User, Loan>  */
    public function borrower(): BelongsTo
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }

    /** @return BelongsTo<User, Loan>  */
    public function attendant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'attendant_id');
    }
}
