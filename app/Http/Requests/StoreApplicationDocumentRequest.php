<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApplicationDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'applicant_id' => ['required', 'exists:applicants,id'],
            'document_type' => ['required', Rule::in(['PHOTO', 'ID', 'DIPLOMA', 'RECO_LETTER'])],
            'file' => ['required', 'file', 'mimes:pdf,jpeg,png,jpg,doc,docx,avif', 'max:5120'],
            'file_name' => ['required', 'string', 'max:100'],
        ];
    }

    public function attributes(): array
    {
        return [
            'applicant_id' => __('validation.attributes.user') ?? 'applicant',
            'document_type' => __('validation.attributes.type'),
            'file' => __('validation.attributes.file') ?? 'file',
            'file_name' => __('validation.attributes.name'),
        ];
    }

    public function messages(): array
    {
        return [
            'applicant_id.required' => __('validation.required'),
            'applicant_id.exists' => __('validation.exists'),

            'document_type.required' => __('validation.required'),
            'document_type.in' => __('validation.in'),

            'file.required' => __('validation.required'),
            'file.file' => __('validation.file'),
            'file.mimes' => __('validation.mimes'),
            'file.max' => __('validation.max.file'),

            'file_name.required' => __('validation.required'),
            'file_name.max' => __('validation.max.string'),
        ];
    }
}
