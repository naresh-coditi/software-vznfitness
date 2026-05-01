<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'max:255|nullable',
            'gender' => 'required',
            'email' => 'nullable|email|regex:/^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix',
            'phone' => 'numeric|required|min:0|unique:users,phone',
            'password' => 'required|min:6|max:255',
            'confirm_password' => 'required|same:password',
            'address' => 'nullable',
            'user_type' => 'nullable',
            'image' => 'nullable|max:2048',
            'branch' => 'required|exists:branches,id',
        ];
    }
}
