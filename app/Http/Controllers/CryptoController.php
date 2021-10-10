<?php

namespace App\Http\Controllers;

use App\Http\Requests\CryptoOperationRequest;
use App\Services\MercadoBitcoin;
use Carbon\Carbon;
use Illuminate\Http\Request;


class CryptoController extends Controller
{
    public function operation(CryptoOperationRequest $request, string $coin)
    {
        try {
            $operation = (new MercadoBitcoin())->operationResume(
                $coin,
                $request->quantidade,
                Carbon::parse($request->dataCompra),
                Carbon::parse($request->dataVenda)
            );

        } catch (\Throwable $e) {
            report($e);
            return response()->json(['message' => 'Não foi possível recuperar as cotações.'], 500);
        }

        return response()->json($operation);
    }
}
