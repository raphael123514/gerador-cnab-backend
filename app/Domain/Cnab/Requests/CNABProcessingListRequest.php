<?php

namespace App\Domain\Cnab\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CNABProcessingListRequest extends FormRequest
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
            'status' => 'sometimes|in:pendente,processando,concluido,erro',
            'date_from' => 'sometimes|date_format:Y-m-d',
            'date_to' => 'sometimes|date_format:Y-m-d',
            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
        ];
    }
}
