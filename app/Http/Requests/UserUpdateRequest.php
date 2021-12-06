<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    protected $errorBag = 'userUpdate';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255|',
            //'email' => 'nullable|string|email|max:255|unique:users',
            'city' => 'nullable|string|max:255',
            'formation' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'skills' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255',
            'role_id' => 'numeric|min:1|max:3',
        ];
    }
}
