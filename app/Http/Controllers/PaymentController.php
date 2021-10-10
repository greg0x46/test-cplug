<?php

namespace App\Http\Controllers;

class PaymentController extends Controller
{
    /**
     * Retorna o numero de parcelas
     *
     * @param float $value Valor total
     * @param float $amount Numero de parcelas
     *
     * @return array
     */
    public function calculate($value, $amount)
    {
        return [
            'value' => (float) $value,
            'amount' => (int) $amount,
            'installments' => $this->getInstallments($value, $amount),
        ];
    }

    private function getInstallments($value, $amount)
    {
        $installmentPrice = round($value / $amount, 2);
        $installmentsTotal = $installmentPrice * $amount;
        $installments = [];

        for($i = 0; $i < $amount; $i++) {
            $installments[] = [
                'order' => $i+1,
                'value' => $i == 0 ? $installmentPrice + ($value - $installmentsTotal) : $installmentPrice
            ];
        }

        return $installments;
    }

}
