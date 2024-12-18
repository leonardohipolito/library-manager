<?php

namespace App\Enums;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

enum LoanStatus implements Htmlable
{
    case borrowed;
    case overdue;
    case returned;

    public function toHtml()
    {
        return $this->label();
    }

    public function label(): string
    {
        return match ($this) {
            self::borrowed => 'Emprestado',
            self::overdue => 'Atrasado',
            self::returned => 'Devolvido'
        };
    }

    public static function options(): Collection
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $status) => [$status->name => $status->label()]);
    }
}
