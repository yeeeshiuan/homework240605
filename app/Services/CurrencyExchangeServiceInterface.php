<?php

namespace App\Services;

interface  CurrencyExchangeServiceInterface
{
    public function exchange(string $source, string $target, string $amount) : string;
}