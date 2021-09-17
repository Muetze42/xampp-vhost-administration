<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PathExist implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $value = unixSep($value);

        return is_dir($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('The folder :attribute doesn\'t exist');
    }
}
