<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'applicant_id' => ['required', 'exists:applicants,id'],
            'started_at' => ['nullable', 'date'],
        ];
    }

    public function attributes(): array
    {
        return [
            'applicant_id' => __('validation.attributes.user') ?? 'applicant',
            'started_at' => __('validation.attributes.started_at') ?? 'started at',
        ];
    }

    public function messages(): array
    {
        return [
            'applicant_id.required' => __('validation.required'),
            'applicant_id.exists' => __('validation.exists'),
            'started_at.date' => __('validation.date'),
        ];
    }
}
