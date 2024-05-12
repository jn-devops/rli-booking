<?php

namespace RLI\Booking\Data;

use Spatie\LaravelData\Data;

class FinancialSchemeData extends Data
{
    public function __construct(
        public float $dp_percent,
        public int $dp_months,
    ) {}
}
