<?php

namespace Tests\Feature;

use Tests\TestCase;

class CurrencyExchangeServiceTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('wrongCurrencies')]
    public function test_wrong_source_input($wrongCurrency): void
    {
        // assign
        $source = $wrongCurrency;

        $target = 'USD';
        $amount = '5566';

        // act
        $response = $this->get('/check?source='.$source.'&target='.$target.'&amount='.$amount);

        // assert
        $response->assertStatus(422)
                 ->assertJsonFragment(['source' => ['The selected source is invalid.']])
                 ->assertJsonMissing(['target' => ['The selected target is invalid.']])
                 ->assertJsonMissing(['amount' => ['The amount must be a valid amount.']]);
    }

    public static function wrongCurrencies()
    {
        return [
            ['XDD'],
            ['EUR'],
            ['CAD'],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('wrongCurrencies')]
    public function test_wrong_target_input($wrongCurrency): void
    {
        // assign
        $target = $wrongCurrency;

        $source = 'TWD';
        $amount = '5566';

        // act
        $response = $this->get('/check?source='.$source.'&target='.$target.'&amount='.$amount);

        // assert
        $response->assertStatus(422)
                 ->assertJsonFragment(['target' => ['The selected target is invalid.']])
                 ->assertJsonMissing(['source' => ['The selected source is invalid.']])
                 ->assertJsonMissing(['amount' => ['The amount must be a valid amount.']]);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('wrongAmounts')]
    public function test_wrong_amount_input($wrongAmount): void
    {
        // assign
        $amount = $wrongAmount;

        $target = 'USD';
        $source = 'TWD';

        // act
        $response = $this->get('/check?source='.$source.'&target='.$target.'&amount='.$amount);

        // assert
        $response->assertStatus(422)
                 ->assertJsonFragment(['amount' => ['The amount must be a valid amount.']])
                 ->assertJsonMissing(['source' => ['The selected source is invalid.']])
                 ->assertJsonMissing(['target' => ['The selected target is invalid.']]);
    }

    public static function wrongAmounts()
    {
        return [
            ['joey'],
            ['556p'],
            ['5,,567'],
            ['56,7'],
            [','],
            ['.'],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('roundAmounts')]
    public function test_round_amount_output_in_the_same_currency($amount, $result): void
    {
        // assign
        $amount = $amount;
        $target = 'TWD';
        $source = 'TWD';

        // act
        $response = $this->get('/check?source='.$source.'&target='.$target.'&amount='.$amount);

        // assert
        $response->assertStatus(200)
                 ->assertJsonFragment(['amount' => $result]);
    }

    public static function roundAmounts()
    {
        return [
            ['12.253', '12.25'],
            ['56.5449', '56.54'],
            ['0.666', '0.67'],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('roundAmountsWithCurrencies')]
    public function test_round_amount_output_in_different_currencies(
        $source, $target, $amount, $result): void
    {
        // assign
        $amount = $amount;
        $target = $target;
        $source = $source;

        // act
        $response = $this->get('/check?source='.$source.'&target='.$target.'&amount='.$amount);

        // assert
        $response->assertStatus(200)
                 ->assertJsonFragment(['amount' => $result]);
    }

    public static function roundAmountsWithCurrencies()
    {
        return [
            // source, target, amount, result
            ['TWD', 'USD', '1828.55', '59.99'],  // 1  ( 59.9947255 )
            ['TWD', 'USD', '1828.6', '60.00'],   // 2  ( 59.996366 )

            ['TWD', 'JPY', '6.2673', '22.99'],   // 3  ( 22.9947237 )
            ['TWD', 'JPY', '6.2674', '23.00'],   // 4  ( 22.9950906 )

            ['USD', 'TWD', '0.42684', '12.99'],  // 5  ( 12.99471696 )
            ['USD', 'TWD', '0.42685', '13.00'],  // 6  ( 12.9950214 )

            ['USD', 'JPY', '5.00885', '559.99'], // 7  ( 559.99443885 )
            ['USD', 'JPY', '5.00886', '560.00'], // 8  ( 559.99555686 )

            ['JPY', 'USD', '1129.3', '9.99'],    // 9  ( 9.994305 )
            ['JPY', 'USD', '1129.4', '10.00'],   // 10 ( 9.99519 )

            ['JPY', 'TWD', '11.11', '2.99'],     // 11 ( 2.9948116 )
            ['JPY', 'TWD', '11.12', '3.00'],     // 12 ( 2.9975072 )
        ];
    }
}
