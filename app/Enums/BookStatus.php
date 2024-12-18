<?php

namespace App\Enums;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

enum BookStatus implements Htmlable
{
    case available;
    case borrowed;

    public function toHtml()
    {
        return $this->label();
    }

    public function label(): string
    {
        return match ($this) {
            self::borrowed => 'Emprestado',
            self::available => 'Disponível',
        };
    }

    public static function options(): Collection
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $status) => [$status->name => $status->label()]);
    }
}
