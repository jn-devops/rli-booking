<?php

namespace RLI\Booking\Traits;

trait HydrateFromModel
{
    public static function fromModel(object $model): self
    {
        return new self(...$model->toData());
    }
}
