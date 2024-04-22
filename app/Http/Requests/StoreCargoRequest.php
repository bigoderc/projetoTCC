<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StoreCargoRequest extends FormRequest
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
            'nome' => ['required','max:255',
            function ($attribute, $value, $fail) {
                $existingMatricula = DB::table('cargos')
                    ->where('nome', $value)
                    ->where('id','<>',$this->id)
                    ->whereNull('deleted_at')
                    ->first();
        
                if ($existingMatricula) {
                    $fail('o cargo já está em uso.');
                }
            }],
        ];
    }
    public function messages()
    {
        return [
            'nome.required' => 'É obrigatorio o cargo',
            'nome.unique' => 'Já existe esse cargo',
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
