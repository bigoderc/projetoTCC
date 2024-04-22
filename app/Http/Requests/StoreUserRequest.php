<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'name' => ['required','max:255'],
            'email' => ['required','max:255',
                function ($attribute, $value, $fail) {
                    $existingUser = DB::table('users')
                        ->where('email', $value)
                        ->where('id','<>',$this->id)
                        ->whereNull('deleted_at')
                        ->first();
            
                    if ($existingUser) {
                        $fail('O e-mail já está em uso.');
                    }
                }
            ],
            'fk_roles_id' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'nome.required' => 'É obrigatorio o nome',
            'email.required' => 'É obrigatorio o email',
            'email.unique' => 'Já existe esse email',
            'fk_roles_id.required' => 'É obrigatorio o perfil'
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
