<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyConverterController extends Controller
{
    //
    public function list() {
        $baseURL = $_ENV['API_BASE_URL'];
        return Http::get($baseURL.'currencies',[
            'apikey'=> 'fca_live_98KeyxW9uz8gHEkwgYBHEppCWBwNE8gukQ6Nbqn8'
        ], 200);
    }

    public function converter(Request $request) {
        $baseURL = $_ENV['API_BASE_URL'];
        return Http::get($baseURL.'latest',[
            'apikey'=> 'fca_live_98KeyxW9uz8gHEkwgYBHEppCWBwNE8gukQ6Nbqn8',
            'base_currency' => $request->base_currency,
            'currencies' => $request->currencies
        ], 200);
    }
}
