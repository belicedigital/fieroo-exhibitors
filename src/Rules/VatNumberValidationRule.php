<?php

namespace Fieroo\Exhibitors\Rules;

use Illuminate\Contracts\Validation\Rule;

class VatNumberValidationRule implements Rule
{
    public function passes($attribute, $value)
    {
        // Perform the VAT number validation logic here
        // You can implement validation rules specific to your country or region
        
        // For EU VAT numbers, a simple example would be to check for a valid format
        return preg_match('/^[A-Z]{2}[0-9A-Z]+$/', $value);
    }

    public function message()
    {
        return __('validation.custom.vat_number.invalid');
    }
}