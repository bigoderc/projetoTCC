<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class AlunoStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->segment(2) ?? 0;
        return [
            //
            'matricula' => ['required','max:255',Rule::unique('alunos')->ignore($this->id)],
            'email' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) {
                    $existingUser = DB::table('users')
                        ->where('email', $value)
                        ->whereNotNull('deleted_at')
                        ->first();
            
                    if ($existingUser) {
                        $fail('O e-mail já está em uso.');
                    }
                },
            ],
        ];
    }
    public function messages()
    {
        return [
            'matricula.required' => 'É obrigatorio a matriucula',
            'matricula.unique' => 'Já existe essa matricula',
            'email.required' => 'É obrigatorio o email',
            'email.unique' => 'Já existe esse email',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $formattedErrors = collect();
        foreach ($errors->messages() as $field => $messages) {

            $formattedErrors->put($field, $messages[0]);
        }
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $formattedErrors->toArray()
        ],422));
    }
}
