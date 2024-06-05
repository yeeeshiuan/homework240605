<?php

namespace App\StaticData;

class CurrencyExchangeRateNormal implements CurrencyExchangeRateInterface
{
    public function getCurrencies(): array
    {
        return [
            "TWD",
            "JPY",
            "USD",
        ];
    }

    public function getCurrencyExchangeRate(): array
    {
        return [
            "currencies" => [
                "TWD" => [
                    "TWD" => 1,
                    "JPY" => 3.669,
                    "USD" => 0.03281,
                ],
                "JPY" => [
                    "TWD" => 0.26956,
                    "JPY" => 1,
                    "USD" => 0.00885,
                ],
                "USD" => [
                    "TWD" => 30.444,
                    "JPY" => 111.801,
                    "USD" => 1,
                ],
            ],
        ];
    }
}