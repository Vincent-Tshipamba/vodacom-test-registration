<?php

return [
    'title' => 'Registration',
    'step_1_title' => 'Personal Information',
    'step_2_title' => 'Address',
    'step_3_title' => 'Academic Information',
    'step_4_title' => 'Attachments',
    'step_5_title' => 'Personal Ambitions',

    // Navigation
    'step' => 'Step',
    'of' => 'of',
    'next' => 'Next',
    'previous' => 'Previous',
    'complete' => 'Submit',

    // Step 1: Personal Information
    'input_photo_label' => 'ID Photo',
    'browse_photo' => 'Upload Photo',
    'browse_photo_label' => 'JPG/PNG format, max 2MB',
    'input_firstname_label' => 'First Name',
    'input_firstname_placeholder' => 'Enter your first name...',
    'input_lastname_label' => 'Last Name',
    'input_lastname_placeholder' => 'Enter your last name...',
    'input_phone_label' => 'Phone Number',
    'input_phone_placeholder' => 'Enter your number...',
    'input_gender_label' => 'Gender',
    'gender_male' => 'Male',
    'gender_female' => 'Female',
    'input_birthdate_label' => 'Date of Birth',
    'input_birthdate_placeholder' => 'DD/MM/YYYY',
    'age_label' => 'Age',
    'years_old' => 'years',

    // Step 2: Address
    'current_city_label' => 'Current City of Residence',
    'current_city_placeholder' => 'Your current city...',
    'diploma_city_label' => 'City of High School Graduation',
    'diploma_city_placeholder' => 'City where you took your state exam...',
    'full_address_label' => 'Full Address',
    'full_address_placeholder' => 'Your complete address...',

    // Step 3: Academic Information
    'school_name_label' => 'School Name',
    'school_name_placeholder' => 'Your high school name...',
    'study_option_label' => 'Field of Study',
    'study_option_placeholder' => 'E.g., Biochemistry, General Education...',
    'personalized_option_field_value' => 'Other (Please specify)',
    'other_study_option_label' => 'Specify your field',
    'other_study_option_placeholder' => 'Enter your field of study',
    'diploma_score_label' => 'State Exam Percentage',
    'diploma_score_placeholder' => 'Your percentage...',
    'diploma_year_label' => 'Year of Graduation',
    'diploma_year_placeholder' => 'Year of graduation...',

    // Step 4: Attachments
    'id_document_label' => 'ID Document',
    'id_document_hint' => 'Voter card, passport, or birth certificate (PDF, JPG, PNG, max 2MB)',
    'diploma_label' => 'Certificate of Success',
    'diploma_hint' => 'Scan of your diploma or certificate (PDF, JPG, PNG, max 2MB)',
    'recommendation_label' => 'Recommendation Letter (optional)',
    'recommendation_hint' => 'Recommendation letter (PDF, DOC, DOCX, max 2MB)',

    // Step 5: Personal Ambitions
    'university_field_label' => 'Desired University Field',
    'university_field_placeholder' => 'E.g., Medicine, Law, Computer Science...',
    'select_option' => 'Select an option',
    'personalized_university_field_value' => 'Other (please specify)',
    'other_university_field_label' => 'Specify your field',
    'other_university_field_placeholder' => 'Enter your field of study',
    'passion_label' => 'What are you passionate about in this field?',
    'passion_placeholder' => 'Describe your motivations and interests...',
    'career_goals_label' => 'Your Career Goals',
    'career_goals_placeholder' => 'Where do you see yourself in 5 years?...',
    'additional_info_label' => 'Additional Information',
    'additional_info_placeholder' => 'Any other information you find relevant...',

    // Validation
    'validation' => [
        'required' => 'This field is required',
        'email' => 'Please enter a valid email address',
        'min' => 'Must be at least :min characters',
        'max' => 'Must not exceed :max characters',
        'file_size' => 'File must not exceed :size MB',
        'file_type' => 'File type not allowed',
        'phone' => 'Invalid phone number',
        'percentage' => 'You must have at least 70% to register for the program',
        'birthdate' => 'Invalid date of birth',
        'age_requirement' => 'You must be at least 16 years old and at most 20 years old to register',
        'diploma_city_help' => 'Leave blank if same as current city of residence',
    ],

    // Confirmation messages
    'confirmation_title' => 'Registration Confirmation',
    'confirmation_message' => 'Your registration has been successfully submitted!',
    'confirmation_details' => 'We have sent a confirmation email to your email address.',
    'return_home' => 'Return to Home',

    // Study options
    'study_options' => [
        'Nursing Assistants',
        'Arts and Crafts',
        'Business',
        'Fashion Design',
        'Electricity',
        'Electronics',
        'Literature',
        'Mechanics',
        'Education',
        'Science',
        'Secretarial Studies',
        'Other (Please specify)'
    ],

    // University fields
    'university_fields' => [
        'Science and Technology' => [
            'Civil Engineering',
            'Mechanical Engineering',
            'Electrical Engineering',
            'Software Engineering',
            'Computer Engineering',
            'Chemical Engineering',
            'Telecommunications Engineering',
            'Applied Mathematics',
            'Physics',
            'Chemistry',
            'Biology',
            'Geology',
            'Environmental Sciences',
        ],
        'Economics and Management' => [
            'Economics',
            'Management Sciences',
            'Business Administration',
            'Human Resources Management',
            'Marketing',
            'Accounting and Finance',
            'Banking and Finance',
            'Insurance',
        ],
        'Law' => [
            'Private and Judicial Law',
            'Public Law',
            'International Law',
            'Economic Law',
        ],
        'Medicine and Health' => [
            'General Medicine',
            'Dentistry',
            'Pharmacy',
            'Nursing Sciences',
            'Public Health',
        ],
        'Arts and Humanities' => [
            'Philosophy',
            'History',
            'Sociology',
            'Psychology',
            'Political Science',
            'International Relations',
        ],
        'Agronomy' => [
            'General Agronomy',
            'Veterinary Sciences',
            'Development Sciences and Techniques',
        ],
        'Other' => 'Other (please specify)'
    ]
];
