<?php

namespace App\Helpers;

class FormOptionsHelper
{
    /**
     * Génère les options pour study_option avec valeurs anglaises et libellés traduits
     *
     * @param string|null $locale
     * @return array
     */
    public static function getStudyOptions(string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();

        $options = [
            'nursing_assistants' => __('registration.values.study_option.nursing_assistants', [], $locale),
            'arts_crafts' => __('registration.values.study_option.arts_crafts', [], $locale),
            'commercial' => __('registration.values.study_option.commercial', [], $locale),
            'sewing_couture' => __('registration.values.study_option.sewing_couture', [], $locale),
            'electricity' => __('registration.values.study_option.electricity', [], $locale),
            'electronics' => __('registration.values.study_option.electronics', [], $locale),
            'literary' => __('registration.values.study_option.literary', [], $locale),
            'mechanics' => __('registration.values.study_option.mechanics', [], $locale),
            'pedagogy' => __('registration.values.study_option.pedagogy', [], $locale),
            'scientific' => __('registration.values.study_option.scientific', [], $locale),
            'secretarial' => __('registration.values.study_option.secretarial', [], $locale),
            'other' => __('registration.values.study_option.other', [], $locale),
        ];

        return $options;
    }

    /**
     * Génère les options pour university_field avec valeurs anglaises et libellés traduits
     *
     * @param string|null $locale
     * @return array
     */
    public static function getUniversityFields(string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();

        $options = [
            'civil_engineering' => __('registration.values.university_field.civil_engineering', [], $locale),
            'mechanical_engineering' => __('registration.values.university_field.mechanical_engineering', [], $locale),
            'electrical_engineering' => __('registration.values.university_field.electrical_engineering', [], $locale),
            'software_engineering' => __('registration.values.university_field.software_engineering', [], $locale),
            'computer_engineering' => __('registration.values.university_field.computer_engineering', [], $locale),
            'chemical_engineering' => __('registration.values.university_field.chemical_engineering', [], $locale),
            'telecommunications_engineering' => __('registration.values.university_field.telecommunications_engineering', [], $locale),
            'applied_mathematics' => __('registration.values.university_field.applied_mathematics', [], $locale),
            'physics' => __('registration.values.university_field.physics', [], $locale),
            'chemistry' => __('registration.values.university_field.chemistry', [], $locale),
            'biology' => __('registration.values.university_field.biology', [], $locale),
            'geology' => __('registration.values.university_field.geology', [], $locale),
            'environmental_sciences' => __('registration.values.university_field.environmental_sciences', [], $locale),
            'economics' => __('registration.values.university_field.economics', [], $locale),
            'management' => __('registration.values.university_field.management', [], $locale),
            'business_administration' => __('registration.values.university_field.business_administration', [], $locale),
            'human_resources' => __('registration.values.university_field.human_resources', [], $locale),
            'marketing' => __('registration.values.university_field.marketing', [], $locale),
            'accounting_finance' => __('registration.values.university_field.accounting_finance', [], $locale),
            'banking_finance' => __('registration.values.university_field.banking_finance', [], $locale),
            'insurance' => __('registration.values.university_field.insurance', [], $locale),
            'private_law' => __('registration.values.university_field.private_law', [], $locale),
            'public_law' => __('registration.values.university_field.public_law', [], $locale),
            'international_law' => __('registration.values.university_field.international_law', [], $locale),
            'economic_law' => __('registration.values.university_field.economic_law', [], $locale),
            'general_medicine' => __('registration.values.university_field.general_medicine', [], $locale),
            'dentistry' => __('registration.values.university_field.dentistry', [], $locale),
            'pharmacy' => __('registration.values.university_field.pharmacy', [], $locale),
            'nursing_sciences' => __('registration.values.university_field.nursing_sciences', [], $locale),
            'public_health' => __('registration.values.university_field.public_health', [], $locale),
            'philosophy' => __('registration.values.university_field.philosophy', [], $locale),
            'history' => __('registration.values.university_field.history', [], $locale),
            'sociology' => __('registration.values.university_field.sociology', [], $locale),
            'psychology' => __('registration.values.university_field.psychology', [], $locale),
            'political_sciences' => __('registration.values.university_field.political_sciences', [], $locale),
            'international_relations' => __('registration.values.university_field.international_relations', [], $locale),
            'general_agronomy' => __('registration.values.university_field.general_agronomy', [], $locale),
            'veterinary_sciences' => __('registration.values.university_field.veterinary_sciences', [], $locale),
            'development_sciences' => __('registration.values.university_field.development_sciences', [], $locale),
            'other' => __('registration.values.university_field.other', [], $locale),
        ];

        return $options;
    }

    /**
     * Génère les options pour identification_type avec valeurs anglaises et libellés traduits
     *
     * @param string|null $locale
     * @return array
     */
    public static function getIdentificationTypes(string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();

        $options = [
            'disabled' => __('registration.values.identification_type.disabled', [], $locale),
            'albinos' => __('registration.values.identification_type.albinos', [], $locale),
            'pygmee' => __('registration.values.identification_type.pygmee', [], $locale),
            'refugee' => __('registration.values.identification_type.refugee', [], $locale),
            'orphan' => __('registration.values.identification_type.orphan', [], $locale),
            'none' => __('registration.values.identification_type.none', [], $locale),
        ];

        return $options;
    }

    /**
     * Génère les options pour gender avec valeurs anglaises et libellés traduits
     *
     * @param string|null $locale
     * @return array
     */
    public static function getGenders(string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();

        $options = [
            'male' => __('registration.values.gender.male', [], $locale),
            'female' => __('registration.values.gender.female', [], $locale),
        ];

        return $options;
    }

    /**
     * Traduit une valeur stockée en base de données
     *
     * @param string $field
     * @param string $value
     * @param string|null $locale
     * @return string
     */
    public static function translateValue(string $field, string $value, string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        return __("registration.values.{$field}.{$value}", [], $locale);
    }
}
