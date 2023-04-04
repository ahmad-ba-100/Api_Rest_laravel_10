<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreEtudiantRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'nom' => 'required',
            'email' => 'required',
            'motdepass' => 'required'

        ];
    }
    public function failedvalidator(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'succes' => true,
            'error' => false,
            'message' => 'Erreur de validation',
            'errorsList' => $validator->errors()
        ]));
    }
    public function messages()
    {
        return [
            'nom.required' => 'un nom doit être fourni',
            'email.required' => 'un email doit être fourni'
        ];
    }
}
