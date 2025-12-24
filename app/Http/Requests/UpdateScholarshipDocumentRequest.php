<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateScholarshipDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'academic_year_record_id' => ['sometimes', 'exists:academic_year_records,id'],
            'document_type' => ['sometimes', Rule::in(['REGISTRATION_PROOF', 'FEES_RECEIPT', 'RESULTS_PROOF'])],
            'file' => ['sometimes', 'file', 'mimes:pdf,jpeg,png,jpg,doc,docx,avif', 'max:5120'],
            'file_name' => ['sometimes', 'string', 'max:100'],
            'verification_status' => ['sometimes', Rule::in(['PENDING', 'APPROVED', 'REJECTED'])],
            'reviewed_by' => ['nullable', 'exists:staff_profiles,id'],
            'rejection_reason' => ['nullable', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'academic_year_record_id' => __('validation.attributes.year') ?? 'academic year record',
            'document_type' => __('validation.attributes.type'),
            'file' => __('validation.attributes.file') ?? 'file',
            'file_name' => __('validation.attributes.name'),
            'verification_status' => __('validation.attributes.status'),
            'reviewed_by' => __('validation.attributes.user') ?? 'reviewer',
            'rejection_reason' => __('validation.attributes.reject_reason') ?? 'rejection reason',
        ];
    }

    public function messages(): array
    {
        return [
            'academic_year_record_id.exists' => __('validation.exists'),
            'document_type.in' => __('validation.in'),
            'file.file' => __('validation.file'),
            'file.mimes' => __('validation.mimes'),
            'file.max' => __('validation.max.file'),
            'file_name.max' => __('validation.max.string'),
            'verification_status.in' => __('validation.in'),
            'reviewed_by.exists' => __('validation.exists'),
        ];
    }
}
