<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CurrencyExchangeAmount implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if the value is an integer
        if (is_int($value)) {
            return;
        }

        // Check if the value is a string with commas
        if (is_string($value) && preg_match('/^\d{1,3}(,\d{3})*(\.\d{2})?$/', $value)) {
            // Remove commas and check if the remaining string is a valid number
            $number = str_replace(',', '', $value);
            if (is_numeric($number))
            {
                return;
            }
        }

        $fail('The :attribute must be a valid amount.');
    }
}