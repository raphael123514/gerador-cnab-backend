<?php

namespace App\Domain\Cnab\Requests;

use App\Domain\Cnab\Enums\ProcessingStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
            'filters' => 'sometimes|array',
            'filters.status' => ['sometimes', new Enum(ProcessingStatus::class)],
            'filters.date_from' => 'sometimes|date_format:Y-m-d',
            'filters.date_to' => 'sometimes|date_format:Y-m-d',

            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
        ];
    }
}
