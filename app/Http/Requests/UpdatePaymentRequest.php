<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'academic_year_record_id' => ['sometimes', 'exists:academic_year_records,id'],
            'amount' => ['sometimes', 'numeric', 'min:0'],
            'currency' => ['sometimes', 'string', 'size:3'],
            'transaction_reference' => ['nullable', 'string', 'max:100'],
            'payment_status' => ['nullable', Rule::in(['PROCESSING', 'PAID', 'FAILED'])],
            'processed_at' => ['nullable', 'date'],
        ];
    }

    public function attributes(): array
    {
        return [
            'academic_year_record_id' => __('validation.attributes.year') ?? 'academic year record',
            'amount' => __('validation.attributes.amount'),
            'currency' => __('validation.attributes.currency'),
            'transaction_reference' => __('validation.attributes.transaction_reference') ?? 'transaction reference',
            'payment_status' => __('validation.attributes.status'),
            'processed_at' => __('validation.attributes.processed_at') ?? 'processed at',
        ];
    }

    public function messages(): array
    {
        return [
            'academic_year_record_id.exists' => __('validation.exists'),
            'amount.numeric' => __('validation.numeric'),
            'amount.min' => __('validation.min.numeric'),
            'currency.size' => __('validation.size.string'),
            'transaction_reference.max' => __('validation.max.string'),
            'payment_status.in' => __('validation.in'),
            'processed_at.date' => __('validation.date'),
        ];
    }
}
