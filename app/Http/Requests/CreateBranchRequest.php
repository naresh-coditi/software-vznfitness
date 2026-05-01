<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBranchRequest extends FormRequest
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
            'name' => 'required|min:0|max:255',
            'location' => 'required|min:0|max:255',
            'phone' => 'numeric|min:0',
            'gst' => 'nullable',
            'open_at' => 'required|date',
            'address' => 'required|min:0|max:400'
        ];
    }
}
