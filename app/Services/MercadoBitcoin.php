<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class MercadoBitcoin extends Crypto
{
    const BASE_URL = 'https://www.mercadobitcoin.net/api';

    public function daySummary(string $coin, Carbon $date): array
    {
        $response = Http::get(self::BASE_URL . "/$coin/day-summary/$date->year/$date->month/$date->day");

        if(!$response->successful()){
           throw $response->toException();
        }

        return $response->json();
    }
}
