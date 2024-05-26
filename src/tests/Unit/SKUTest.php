<?php
use RLI\Booking\Classes\SKU;

test('sku returns code with prefix', function () {
    $prefix = 'LBH';
    $attribs = [
        'project_code' => 'PHH1',
        'total_contract_price' => '817000',
        'lot_area' => '30',
        'floor_area' => '32',
        'unit_type' => 'THEUWFW'
    ];
    $sku = new SKU($attribs, $prefix);
    expect($sku->toCode())->toBe('LBH-PHH1-817000-30-32-THEUWFW');
});

test('sku returns code with default', function () {
    $attribs = [
        'project_code' => 'PHH1',
        'total_contract_price' => '817000',
        'lot_area' => '30',
        'floor_area' => '32',
        'unit_type' => 'THEUWFW'
    ];
    $sku = new SKU($attribs);
    expect($sku->toCode())->toBe('JN-PHH1-817000-30-32-THEUWFW');
});
