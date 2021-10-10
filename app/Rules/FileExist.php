<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class FileExist implements Rule
{
    public ?string $file = null;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        if($request->input('installer')) {
            $installer = config('installers.'.$request->input('installer'));
            $this->file = !empty($installer['file']) ? $installer['file'] : null;
        }
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return !$this->file || file_exists($this->file);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return  __('File „:file“ not found', ['file' => $this->file]);
    }
}
