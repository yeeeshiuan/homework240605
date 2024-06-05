<?php

namespace App\StaticData;

interface CurrencyExchangeRateInterface
{
    public function getCurrencies(): array;
    public function getCurrencyExchangeRate(): array;
}