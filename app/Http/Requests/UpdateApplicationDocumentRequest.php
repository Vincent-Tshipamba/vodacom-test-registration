<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApplicationDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'applicant_id' => ['sometimes', 'exists:applicants,id'],
            'document_type' => ['sometimes', Rule::in(['ID', 'DIPLOMA', 'RECO_LETTER'])],
            'file' => ['sometimes', 'file', 'mimes:pdf,jpeg,png,jpg,doc,docx,avif', 'max:5120'],
            'file_name' => ['sometimes', 'string', 'max:100'],
            'is_valid' => ['nullable', 'boolean'],
            'reviewed_by' => ['nullable', 'exists:staff_profiles,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'applicant_id' => __('validation.attributes.user') ?? 'applicant',
            'document_type' => __('validation.attributes.type'),
            'file' => __('validation.attributes.file') ?? 'file',
            'file_name' => __('validation.attributes.name'),
            'reviewed_by' => __('validation.attributes.user') ?? 'reviewer',
        ];
    }

    public function messages(): array
    {
        return [
            'applicant_id.exists' => __('validation.exists'),
            'document_type.in' => __('validation.in'),
            'file.file' => __('validation.file'),
            'file.mimes' => __('validation.mimes'),
            'file.max' => __('validation.max.file'),
            'file_name.max' => __('validation.max.string'),
            'reviewed_by.exists' => __('validation.exists'),
        ];
    }
}
