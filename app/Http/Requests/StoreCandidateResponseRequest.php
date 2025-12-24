<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCandidateResponseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'test_session_id' => ['required', 'exists:test_sessions,id'],
            'question_id' => ['required', 'exists:questions,id'],
            'selected_option_id' => ['nullable', 'exists:answer_options,id', 'required_without:text_answer'],
            'text_answer' => ['nullable', 'string', 'max:5000', 'required_without:selected_option_id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'test_session_id' => __('validation.attributes.test_name') ?? 'test session',
            'question_id' => __('validation.attributes.question') ?? 'question',
            'selected_option_id' => __('validation.attributes.option') ?? 'option',
            'text_answer' => __('validation.attributes.text') ?? 'text answer',
        ];
    }

    public function messages(): array
    {
        return [
            'test_session_id.required' => __('validation.required'),
            'test_session_id.exists' => __('validation.exists'),

            'question_id.required' => __('validation.required'),
            'question_id.exists' => __('validation.exists'),

            'selected_option_id.exists' => __('validation.exists'),
            'selected_option_id.required_without' => __('validation.required'),

            'text_answer.string' => __('validation.string'),
            'text_answer.max' => __('validation.max.string'),
            'text_answer.required_without' => __('validation.required'),
        ];
    }
}
