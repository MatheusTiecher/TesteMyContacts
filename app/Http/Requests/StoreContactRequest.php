<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'cpf' => 'required|cpf|unique:contacts,cpf',
            'type' => 'required|integer|in:1,2,3,4',
            'cellphone' => 'required',
            'address' => 'required',
            'number' => 'required',
            'district' => 'required',
            'zipcode' => 'required|size:8',
            'complement' => '',
            'city_id' => 'required|exists:cities,id',
        ];
    }
}
