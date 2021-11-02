<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckPassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $uppercase = preg_match('@[A-Z]@', $value);
        $lowercase = preg_match('@[a-z]@', $value);
        $number    = preg_match('@[0-9]@', $value);
        $specialChars = preg_match('@[^\w]@', $value);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($value) < 8) {
            return false;
        }else{
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
        return trans('auth.password_validation');
    }
}
