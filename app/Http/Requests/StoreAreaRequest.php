<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StoreAreaRequest extends FormRequest
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
            'nome' => ['required','max:60',
            function ($attribute, $value, $fail) {
                $existingMatricula = DB::table('areas')
                    ->where('nome', $value)
                    ->where('id','<>',$this->id)
                    ->whereNull('deleted_at')
                    ->first();
        
                if ($existingMatricula) {
                    $fail('a área já está em uso.');
                }
            }],
        ];
    }
    public function messages()
    {
        return [
            'nome.required' => 'É obrigatorio a área',
            'nome.unique' => 'Já existe essa área',
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
