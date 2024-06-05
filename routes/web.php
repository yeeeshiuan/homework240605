<?php

use App\Http\Requests\CurrencyExchangeRequest;
use App\Services\CurrencyExchangeServiceInterface;

use Illuminate\Support\Facades\Route;

Route::get('check', function (CurrencyExchangeRequest $request) {
    $newAmount = app(CurrencyExchangeServiceInterface::class)->exchange(
        $request->input('source'),
        $request->input('target'),
        $request->input('amount')
    );

    return response()->json([
        'msg' => 'success',
        'amount' => $newAmount,
    ]);
});
