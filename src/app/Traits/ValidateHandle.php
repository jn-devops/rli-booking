<?php

namespace RLI\Booking\Traits;

use Illuminate\Support\Facades\Validator;
use ReflectionMethod;

trait ValidateHandle
{
    public static function execute(...$arguments): mixed
    {
        $action = static::make();
        $argName = $action->validated ?? 'validated';
        foreach ((new ReflectionMethod(static::class, 'handle'))->getParameters() as $parameter) {
            if (($parameter->name == $argName) and ($parameter->getType() == 'array')) {
                $attribs = func_get_args()[$parameter->getPosition()];

                return $action->handle(Validator::validate($attribs, $action->rules()));
            }
        }

        return $action->handle(...$arguments);
    }
}
