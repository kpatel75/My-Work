<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EqualsYearAndDescription implements Rule
{
    protected $year;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($year)
    {
        $this->year = $year;
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
        $fd = DB::table('fees')
                ->select('fees.year', 'fee_descriptions.description')
                ->leftjoin('fee_descriptions', 'fees.description_id', '=', 'fee_descriptions.id')
                ->where([
                    ['fees.year', '=', $this->year],
                    ['fee_descriptions.description', '=', $value],
                    ['fees.jurisdiction_id', '=', Auth::user()->jurisdiction_id],
                    ['fees.chapter_id', '=', Auth::user()->chapter_id]])
                ->get();

        if ($fd->count() > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'There is already a fee with the same description and year as the one being enetered!';
    }
}
