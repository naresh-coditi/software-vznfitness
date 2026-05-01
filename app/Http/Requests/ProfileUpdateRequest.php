<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'first_name' => 'required|max:255',
            'email' => 'nullable|email',
            'last_name' => 'nullable|max:255',
            'gender' => 'nullable',
            'phone' => 'required',
            'address' => 'nullable',
        ];
    }
}
