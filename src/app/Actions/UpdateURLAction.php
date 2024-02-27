<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Classes\Bitly;

class UpdateURLAction
{
    use AsAction;

    public function __construct(protected Bitly $bitly){}

    public function handle(string $short_link, string $title): bool
    {

    }
}
