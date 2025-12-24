<?php

namespace App\Http\Requests;

use App\Models\Applicant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApplicantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
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
            // 'user_id' => ['required', 'exists:users,id'],
            // 'edition_id' => ['required', 'exists:scholarship_editions,id'],
            // 'registration_code' => ['required', 'string', 'max:50', 'unique:applicants,registration_code'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'phone_number' => ['required', 'string', 'max:20'],
            'vulnerability_type' => ['required', Rule::in($vulnerabilityTypes)],
            'diploma_city' => ['required', 'string', 'max:100'],
            'current_city' => ['required', 'string', 'max:100'],
            'full_address' => ['required', 'string'],
            'school_name' => ['required', 'string', 'max:150'],
            'national_exam_code' => ['required', 'string', 'size:14', 'regex:/^[0-9]{14}$/', Rule::unique(Applicant::class, 'national_exam_code')],
            'percentage' => ['required', 'numeric', 'min:50', 'max:100'],
            'option_studied' => ['required', Rule::in($studyOptions)],
            'intended_field' => ['required', Rule::in($universityFields)],
            'intended_field_motivation' => ['required', 'string'],
            'intended_field_motivation_locale' => ['required', 'string', Rule::in($supportedLocales)],
            'career_goals' => ['required', 'string'],
            'career_goals_locale' => ['required', 'string', Rule::in($supportedLocales)],
            'additional_infos' => ['nullable', 'string'],
            'additional_infos_locale' => ['nullable', 'string', Rule::in($supportedLocales)],
            'application_status' => ['nullable', 'string', Rule::in(['PENDING', 'REJECTED', 'SHORTLISTED', 'TEST_PASSED', 'INTERVIEW_PASSED', 'ADMITTED'])],
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
            // 'user_id.required' => __('validation.required'),
            // 'user_id.exists' => __('validation.exists'),

            // 'edition_id.required' => __('validation.required'),
            // 'edition_id.exists' => __('validation.exists'),

            // 'registration_code.required' => __('validation.required'),
            // 'registration_code.unique' => __('validation.unique'),
            // 'registration_code.max' => __('validation.max.string'),

            'first_name.required' => __('validation.required'),
            'first_name.max' => __('validation.max.string'),

            'last_name.required' => __('validation.required'),
            'last_name.max' => __('validation.max.string'),

            'gender.required' => __('validation.required'),
            'gender.in' => __('validation.in'),

            'vulnerability_type.required' => __('validation.required'),
            'date_of_birth.required' => __('validation.required'),
            'date_of_birth.date' => __('validation.date'),
            'date_of_birth.before' => __('validation.before'),

            'phone_number.required' => __('validation.required'),
            'phone_number.max' => __('validation.max.string'),

            'diploma_city.required' => __('validation.required'),
            'diploma_city.max' => __('validation.max.string'),

            'current_city.required' => __('validation.required'),
            'current_city.max' => __('validation.max.string'),

            'full_address.required' => __('validation.required'),

            'school_name.required' => __('validation.required'),
            'school_name.max' => __('validation.max.string'),

            'national_exam_code.required' => __('validation.required'),
            'national_exam_code.unique' => __('validation.unique'),
            'national_exam_code.size' => __('validation.size.string'),
            'national_exam_code.regex' => __('validation.regex'),

            'percentage.required' => __('validation.required'),
            'percentage.numeric' => __('validation.numeric'),
            'percentage.min' => __('validation.min.numeric'),
            'percentage.max' => __('validation.max.numeric'),

            'option_studied.required' => __('validation.required'),
            'option_studied.in' => __('validation.in'),

            'intended_field.required' => __('validation.required'),
            'intended_field.in' => __('validation.in'),

            'intended_field_motivation.required' => __('validation.required'),
            'intended_field_motivation_locale.required' => __('validation.required'),
            'intended_field_motivation_locale.in' => __('validation.in'),

            'career_goals.required' => __('validation.required'),
            'career_goals_locale.required' => __('validation.required'),
            'career_goals_locale.in' => __('validation.in'),

            'additional_infos.string' => __('validation.string'),
            'additional_infos_locale.in' => __('validation.in'),

            'application_status.in' => __('validation.in'),
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('national_exam_code')) {
            $normalized = preg_replace('/\D+/', '', (string) $this->input('national_exam_code'));
            $this->merge([
                'national_exam_code' => $normalized,
            ]);
        }

        $this->merge([
            'intended_field_motivation_locale' => $this->get('intended_field_motivation_locale', app()->getLocale()),
            'career_goals_locale' => $this->get('career_goals_locale', app()->getLocale()),
            'additional_infos_locale' => $this->get('additional_infos_locale', app()->getLocale()),
        ]);
    }
}
