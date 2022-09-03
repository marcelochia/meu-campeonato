<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ChampionshipRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:3', 'unique:championships'],
            'teams.1' => ['exists:teams,id'],
            'teams.2' => ['exists:teams,id'],
            'teams.3' => ['exists:teams,id'],
            'teams.4' => ['exists:teams,id'],
            'teams.5' => ['exists:teams,id'],
            'teams.6' => ['exists:teams,id'],
            'teams.7' => ['exists:teams,id'],
            'teams.8' => ['exists:teams,id']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome do campeonato é obrigatório.',
            'name.min' => 'O nome do campeonato deve conter ao menos 5 caracteres.',
            'name.unique' => 'Um campeonato com esse nome já foi cadastrado'
        ];
    }
    
    protected function failedValidation(Validator $validator)
    {
        $response = new Response(['error' => $validator->errors()->all()], 422);
        throw new ValidationException($validator, $response);
    }
}
