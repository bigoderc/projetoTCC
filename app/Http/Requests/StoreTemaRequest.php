<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreTemaRequest extends FormRequest
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
            'nome' => ['required','max:255',Rule::unique('temas')->ignore($this->id)],
            'fk_areas_id' => ['required'],
            'arquivo' => 'mimes:pdf',
        ];
    }
    public function messages()
    {
        return [
            'nome.required' => 'É obrigatorio o nome do tema',
            'nome.unique' => 'Já existe esse tema',
            'fk_areas_id.required' => 'É obrigatorio a área',
            'arquivo.mimes' => 'O arquivo do projeto deve ser um PDF.'
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
