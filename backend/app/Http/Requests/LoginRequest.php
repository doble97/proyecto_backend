<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'The email field must be a valid email address.',
            'password.required' => 'The password field is required.',
        ];
    }


    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if (!$this->attemptLogin()) {
                $validator->errors()->add('email', 'Credenciales inválidas');
            }
        });
    }

    public function attemptLogin()
    {
        $credentials = $this->only(['email', 'password']);
        return auth()->attempt($credentials);
    }

    protected function failedValidation($validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'data' => $validator->errors()
        ], 401));
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> remotes/origin/jorge
