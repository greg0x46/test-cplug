<?php

namespace App\Services;

use Carbon\Carbon;

abstract class Crypto
{
    abstract public function daySummary(string $coin, Carbon $data): array;

    public function operationResume(string $coin, float $amount, Carbon $buyDate, Carbon $sellDate)
    {
        $buy = $this->daySummary($coin, $buyDate);
        $sell = $this->daySummary($coin, $sellDate);

        $buyPrice = $buy['avg_price'] * $amount;
        $sellPrice = $sell['avg_price'] * $amount;
        $profit = round($sell['avg_price'] * $amount - $buy['avg_price'] * $amount, 2);

        return [
            'valor_da_compra' => round($buyPrice, 2),
            'valor_da_venda' => round($sellPrice, 2),
            'lucro' => round($profit, 2),
            'lucro_percentual' => round($profit * 100 / $buyPrice, 2),
            'intervalo_em_dias' => $buyDate->diffInDays($sellDate)
        ];
    }
}
