<?php
use RLI\Booking\Classes\UnitType;

test('unit type returns model', function () {
    $unit_type = 'TOWNHOUSE INNER UNIT (W/ FIREWALL)';
    $ut = new UnitType($unit_type);
    expect($ut->toModel())->toBe('THIUWFW');
});
