<?php

namespace RLI\Booking\Interfaces;

interface CanHydrateFromModel
{
    public static function fromModel(object $model): self;
}
