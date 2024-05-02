<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

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
            'cpf' => 'required|cpf|unique:contacts,cpf,' . $this->id,
            'cellphone' => 'required',
            'type' => 'required|integer|in:1,2,3,4',
            'address' => 'required',
            'number' => 'required',
            'district' => 'required',
            'zipcode' => 'required|size:8',
            'complement' => '',
            'city_id' => 'required|exists:cities,id',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'cpf' => preg_replace('/[^0-9]/', '', $this->cpf),
            'zipcode' => preg_replace('/[^0-9]/', '', $this->zipcode),
        ]);
    }
}
