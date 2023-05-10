<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Validator;

class RegisterRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
<<<<<<< HEAD
            'password' => 'required|string|min:8',
=======
            'password' => 'required|string|min:8|confirmed',
>>>>>>> remotes/origin/jorge
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El campo correo electrónico debe ser una dirección de correo electrónico válida.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'email.unique' => 'The email has already been taken',
            'password.min' => 'El campo contraseña debe tener al menos :min caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ];
    }
    
    protected function failedValidation($validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'data' => $validator->errors()
        ], 422));
    }

}
    // public function withValidator(Validator $validator)
    // {
    //     $validator->after(function ($validator) {
    //         if (!$this->attemptLogin()) {
    //             $validator->errors()->add('email', 'Credenciales inválidas');
    //         }
    //     });
    // }

    // public function attemptLogin()
    // {
    //     $credentials = $this->only(['email', 'password']);
    //     return auth()->attempt($credentials);
<<<<<<< HEAD
    // }
=======
    // }
>>>>>>> remotes/origin/jorge
