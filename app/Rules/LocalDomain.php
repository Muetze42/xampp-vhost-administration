<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LocalDomain implements Rule
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
        return (bool) preg_match('~^[a-z0-9-.]+$~i', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('The :attribute is not a valid domain.');
    }
}
