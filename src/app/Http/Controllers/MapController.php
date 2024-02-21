<?php

namespace RLI\Booking\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $sku = null, string $voucher_number = null, string $property_code = null)
    {   
        $request['sku'] = $sku;
        $request['voucher_number'] = $voucher_number;
        $request['property_code'] = $property_code;

        return view('map.map', compact('request'));
    }
}
