<?php

namespace App\Http\Requests;

use App\Rules\RuleId;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeckIdRequest extends FormRequest
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
        // return [
        //     'id' => ['required', 'integer', function ($attribute, $value, $fail) {
        //         if (!is_numeric($value)) {
        //             $fail('El valor del campo :attribute debe ser numérico.');
        //         }
        //     }],
        // ];
        return [
            // 'id' => ['required', 'numeric', 'exists:decks,id'],
            'id'=>['required','numeric',new RuleId]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Error en la validación de los datos.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
