<?php

namespace App\Http\Requests;

use App\Rules\CurrencyExchangeAmount;
use App\StaticData\CurrencyExchangeRateInterface;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CurrencyExchangeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $availableCurrencies = app(CurrencyExchangeRateInterface::class)->getCurrencies();

        return [
            'source' => [
                'required',
                'string',
                Rule::in($availableCurrencies),
             ],
            'target' => [
                'required',
                'string',
                Rule::in($availableCurrencies),
             ],
            'amount' => [
                'required',
                 new CurrencyExchangeAmount()
             ],
        ];
    }
}
