<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user->id;

        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId)->whereNull('deleted_at'),
            ],
            'image' => [
                'image',
                'max:1024',
                'mimes:jpg,png',
            ],
            'is_admin' => 'required|string|max:10',
        ];

        if (!empty($this->input('password'))) {
            $rules['password'] = ['sometimes', 'required', 'string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])/', 'confirmed'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'password.regex' => 'パスワードは少なくとも1つの半角英字、数字、および記号（@$!%*?&）を含む必要があります。',
        ];
    }
}