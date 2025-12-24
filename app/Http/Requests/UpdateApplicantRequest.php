<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApplicantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $applicantId = $this->route('applicant')?->id ?? $this->input('id');

        $supportedLocales = ['fr', 'en', 'ln', 'sw'];
        $studyOptions = [
            'nursing_assistants',
            'arts_crafts',
            'commercial',
            'sewing_couture',
            'electricity',
            'electronics',
            'literary',
            'mechanics',
            'pedagogy',
            'scientific',
            'secretarial',
            'other'
        ];
        $universityFields = [
            'civil_engineering',
            'mechanical_engineering',
            'electrical_engineering',
            'software_engineering',
            'computer_engineering',
            'chemical_engineering',
            'telecommunications_engineering',
            'applied_mathematics',
            'physics',
            'chemistry',
            'biology',
            'geology',
            'environmental_sciences',
            'economics',
            'management',
            'business_administration',
            'human_resources',
            'marketing',
            'accounting_finance',
            'banking_finance',
            'insurance',
            'private_law',
            'public_law',
            'international_law',
            'economic_law',
            'general_medicine',
            'dentistry',
            'pharmacy',
            'nursing_sciences',
            'public_health',
            'philosophy',
            'history',
            'sociology',
            'psychology',
            'political_sciences',
            'international_relations',
            'general_agronomy',
            'veterinary_sciences',
            'development_sciences',
            'other'
        ];
        $vulnerabilityTypes = ['disabled', 'albinos', 'pygmee', 'refugee', 'orphan', 'none'];

        return [
            'user_id' => ['sometimes', 'exists:users,id'],
            'edition_id' => ['sometimes', 'exists:scholarship_editions,id'],
            'registration_code' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('applicants', 'registration_code')->ignore($applicantId)
            ],
            'first_name' => ['sometimes', 'string', 'max:100'],
            'last_name' => ['sometimes', 'string', 'max:100'],
            'gender' => ['sometimes', Rule::in(['male', 'female'])],
            'date_of_birth' => ['sometimes', 'date', 'before:today'],
            'phone_number' => ['sometimes', 'string', 'max:20'],
            'vulnerability_type' => ['nullable', Rule::in($vulnerabilityTypes)],
            'diploma_city' => ['sometimes', 'string', 'max:100'],
            'current_city' => ['sometimes', 'string', 'max:100'],
            'full_address' => ['sometimes', 'string'],
            'school_name' => ['sometimes', 'string', 'max:150'],
            'national_exam_code' => ['sometimes', 'string', 'size:14', 'regex:/^[0-9]{14}$/'],
            'percentage' => ['sometimes', 'numeric', 'min:50', 'max:100'],
            'option_studied' => ['sometimes', Rule::in($studyOptions)],
            'intended_field' => ['sometimes', Rule::in($universityFields)],
            'intended_field_motivation' => ['sometimes', 'string'],
            'intended_field_motivation_locale' => ['sometimes', 'string', Rule::in($supportedLocales)],
            'career_goals' => ['sometimes', 'string'],
            'career_goals_locale' => ['sometimes', 'string', Rule::in($supportedLocales)],
            'additional_infos' => ['nullable', 'string'],
            'additional_infos_locale' => ['nullable', 'string', Rule::in($supportedLocales)],
            'application_status' => ['sometimes', 'string', Rule::in(['PENDING', 'REJECTED', 'SHORTLISTED', 'TEST_PASSED', 'INTERVIEW_PASSED', 'ADMITTED'])],
        ];
    }

    public function attributes(): array
    {
        return [
            'user_id' => __('validation.attributes.user'),
            'edition_id' => __('validation.attributes.year'),
            'registration_code' => __('validation.attributes.promo_code'),
            'first_name' => __('validation.attributes.first_name'),
            'last_name' => __('validation.attributes.last_name'),
            'gender' => __('validation.attributes.gender'),
            'date_of_birth' => __('validation.attributes.date_of_birth'),
            'phone_number' => __('validation.attributes.phone'),
            'vulnerability_type' => __('validation.attributes.type'),
            'diploma_city' => __('validation.attributes.city'),
            'current_city' => __('validation.attributes.city'),
            'full_address' => __('validation.attributes.address'),
            'school_name' => __('validation.attributes.name'),
            'national_exam_code' => __('validation.attributes.national_code'),
            'percentage' => __('validation.attributes.percentage') ?? 'percentage',
            'option_studied' => __('validation.attributes.specialization') ?? 'option studied',
            'intended_field' => __('validation.attributes.field') ?? 'intended field',
            'intended_field_motivation' => __('validation.attributes.motivation') ?? 'motivation',
            'intended_field_motivation_locale' => __('validation.attributes.locale') ?? 'locale',
            'career_goals' => __('validation.attributes.career_goals') ?? 'career goals',
            'career_goals_locale' => __('validation.attributes.locale') ?? 'locale',
            'additional_infos' => __('validation.attributes.additional_infos') ?? 'additional infos',
            'additional_infos_locale' => __('validation.attributes.locale') ?? 'locale',
            'application_status' => __('validation.attributes.status'),
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.exists' => __('validation.exists'),

            'edition_id.exists' => __('validation.exists'),

            'registration_code.unique' => __('validation.unique'),
            'registration_code.max' => __('validation.max.string'),

            'first_name.max' => __('validation.max.string'),
            'last_name.max' => __('validation.max.string'),
            'gender.max' => __('validation.max.string'),

            'date_of_birth.date' => __('validation.date'),

            'phone_number.max' => __('validation.max.string'),

            'diploma_city.max' => __('validation.max.string'),
            'current_city.max' => __('validation.max.string'),

            'school_name.max' => __('validation.max.string'),

            'national_exam_code.size' => __('validation.size.string'),

            'percentage.numeric' => __('validation.numeric'),
            'percentage.between' => __('validation.between.numeric'),

            'option_studied.max' => __('validation.max.string'),
            'intended_field.max' => __('validation.max.string'),

            'additional_infos.string' => __('validation.string'),
            'additional_infos_locale.string' => __('validation.string'),

            'application_status.in' => __('validation.in'),
        ];
    }
}
