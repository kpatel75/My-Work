<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class GreaterThanFeeAmountD implements Rule
{
    // Validation for demolay input in fees blade
    protected $fee, $chapter;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($fee, $chapter)
    {
        $this->fee = $fee;
        $this->chapter = $chapter;
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
        if ($value + $this->chapter > $this->fee) {
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
