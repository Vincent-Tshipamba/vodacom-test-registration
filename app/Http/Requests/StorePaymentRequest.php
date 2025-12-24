<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'academic_year_record_id' => ['required', 'exists:academic_year_records,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
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
            'academic_year_record_id.required' => __('validation.required'),
            'academic_year_record_id.exists' => __('validation.exists'),

            'amount.required' => __('validation.required'),
            'amount.numeric' => __('validation.numeric'),
            'amount.min' => __('validation.min.numeric'),

            'currency.required' => __('validation.required'),
            'currency.size' => __('validation.size.string'),

            'transaction_reference.max' => __('validation.max.string'),

            'payment_status.in' => __('validation.in'),
            'processed_at.date' => __('validation.date'),
        ];
    }
}
