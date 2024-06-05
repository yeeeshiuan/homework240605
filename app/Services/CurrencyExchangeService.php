<?php

namespace App\Services;

use App\StaticData\CurrencyExchangeRateInterface;

class CurrencyExchangeService implements CurrencyExchangeServiceInterface
{
    protected array $currencyExchangeRate;

    function __construct(CurrencyExchangeRateInterface $currencyExchangeRate)
    {
        $this->currencyExchangeRate = $currencyExchangeRate->getCurrencyExchangeRate();
    }

    public function exchange(string $source, string $target, string $amount) : string
    {
        $rate = $this->currencyExchangeRate['currencies'][$source][$target];
        $numberAmount = str_replace(',', '', $amount);
        $newAmount = round((float)$numberAmount * $rate, $precision = 2);
        return number_format($newAmount, 2, '.', ',');
    }
}
