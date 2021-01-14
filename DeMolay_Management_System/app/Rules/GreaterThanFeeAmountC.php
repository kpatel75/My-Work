<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class GreaterThanFeeAmountC implements Rule
{
    // Validation for chapter input in fees blade
    protected $fee, $demolay;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($fee, $demolay)
    {
        $this->fee = $fee;
        $this->demolay = $demolay;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($value + $this->demolay > $this->fee) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The total contribution is greater than the fee amount.';
    }
}
