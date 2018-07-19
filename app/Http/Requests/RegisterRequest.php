<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterRequest
 * @package App\Http\Requests
 */
class RegisterRequest extends FormRequest
{
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
            'name'            => 'required|min:7',
            'email'           => 'required|min:10|max:70|email|unique:users',
            'password'        => 'required|min:6',
            'passwordConfirm' => 'required|same:password'
        ];
    }
}
