<?php

return [
    'title' => 'Inscription',
    'step_1_title' => 'Informations personnelles',
    'step_2_title' => 'Adresse',
    'step_3_title' => 'Informations scolaires',
    'step_4_title' => 'Pièces jointes',
    'step_5_title' => 'Ambitions personnelles',

    // Navigation
    'step' => 'Étape',
    'of' => 'sur',
    'next' => 'Suivant',
    'previous' => 'Précédent',
    'complete' => 'Soumettre',

    // Étape 1: Informations personnelles
    'input_photo_label' => 'Photo d\'identité',
    'browse_photo' => 'Télécharger une photo',
    'browse_photo_label' => 'Format JPG/PNG, max 2MB',
    'input_firstname_label' => 'Prénom',
    'input_firstname_placeholder' => 'Entrez votre prénom...',
    'input_lastname_label' => 'Nom',
    'input_lastname_placeholder' => 'Entrez votre nom...',
    'input_phone_label' => 'Numéro de téléphone',
    'input_phone_placeholder' => 'Entrez votre numéro...',
    'input_gender_label' => 'Genre',
    'gender_male' => 'Masculin',
    'gender_female' => 'Féminin',
    'input_birthdate_label' => 'Date de naissance',
    'input_birthdate_placeholder' => 'JJ/MM/AAAA',
    'age_label' => 'Âge',
    'years_old' => 'ans',
    'identification_type_label' => 'Veuillez sélectionner ce qui vous identifie',
    'identification_type_disabled' => 'Porteur de handicap',
    'identification_type_albinos' => 'Je suis albinos',
    'identification_type_pygmee' => 'Je suis Pygmée',
    'identification_type_refugee' => 'Je vis dans un camp de réfugiés',
    'identification_type_orphan' => 'Je suis orphelin de militaire tombé au front',
    'identification_type_none' => 'Rien de tout ceci ne s\'applique à moi',
    'student_code_label' => 'Code élève (14 chiffres)',
    'student_code_placeholder' => 'Entrez votre code élève à 14 chiffres...',

    // Étape 2: Adresse
    'current_city_label' => 'Ville de résidence actuelle',
    'current_city_placeholder' => 'Votre ville actuelle...',
    'diploma_city_label' => 'Ville d\'obtention du diplôme d\'État',
    'diploma_city_placeholder' => 'Ville où vous avez passé l\'examen d\'État...',
    'full_address_label' => 'Adresse complète',
    'full_address_placeholder' => 'Votre adresse complète...',

    // Étape 3: Informations scolaires
    'school_name_label' => 'Nom de l\'établissement',
    'school_name_placeholder' => 'Nom de votre école secondaire...',
    'study_option_label' => 'Option suivie',
    'study_option_placeholder' => 'Ex: Biochimie, Pédagogie Générale...',
    'personalized_option_field_value' => 'Autre (Veuillez spécifier)',
    'other_study_option_label' => 'Précisez votre option',
    'other_study_option_placeholder' => 'Entrez votre option d\'étude',
    'diploma_score_label' => 'Pourcentage à l\'examen d\'État',
    'diploma_score_placeholder' => 'Votre pourcentage...',
    'diploma_year_label' => 'Année d\'obtention',
    'diploma_year_placeholder' => 'Année d\'obtention du diplôme...',

    // Étape 4: Pièces jointes
    'id_document_label' => 'Pièce d\'identité',
    'id_document_hint' => 'Carte d\'électeur, passeport ou acte de naissance (PDF, JPG, PNG, max 2MB)',
    'diploma_label' => 'Attestation de réussite',
    'diploma_hint' => 'Scan de votre diplôme ou attestation de réussite (PDF, JPG, PNG, max 2MB)',
    'recommendation_label' => 'Lettre de recommandation (optionnelle)',
    'recommendation_hint' => 'Lettre de recommandation (PDF, DOC, DOCX, max 2MB)',

    // Étape 5: Ambitions personnelles
    'university_field_label' => 'Filière universitaire souhaitée',
    'university_field_placeholder' => 'Ex: Médecine, Droit, Informatique...',
    'select_option' => 'Sélectionnez une option',
    'personalized_university_field_value' => 'Autre (veuillez préciser)',
    'other_university_field_label' => 'Précisez votre filière',
    'other_university_field_placeholder' => 'Entrez le nom de votre filière',
    'passion_label' => 'Qu\'est-ce qui vous passionne dans ce domaine ?',
    'passion_placeholder' => 'Décrivez vos motivations et intérêts...',
    'career_goals_label' => 'Vos objectifs de carrière',
    'career_goals_placeholder' => 'Où vous voyez-vous dans 5 ans ?...',
    'additional_info_label' => 'Informations complémentaires',
    'additional_info_placeholder' => 'Toute autre information que vous jugez utile...',

    // Validation
    'validation' => [
        'pattern' => 'Le code doit contenir exactement 14 chiffres',
        'required' => 'Ce champ est obligatoire',
        'email' => 'Veuillez entrer une adresse email valide',
        'min' => 'Doit contenir au moins :min caractères',
        'max' => 'Ne doit pas dépasser :max caractères',
        'file_size' => 'Le fichier ne doit pas dépasser :size MB',
        'file_type' => 'Type de fichier non autorisé',
        'phone' => 'Numéro de téléphone invalide',
        'percentage' => 'Vous devez avoir au moins 70% pour vous inscrire au programme',
        'birthdate' => 'Date de naissance invalide',
        'age_requirement' => 'Vous devez avoir au moins 16 ans et au plus 20 ans pour vous inscrire',
        'diploma_city_help' => 'Laissez vide si identique à la ville de résidence actuelle',
    ],

    // Messages de confirmation
    'confirmation_title' => 'Confirmation d\'inscription',
    'confirmation_message' => 'Votre inscription a été enregistrée avec succès !',
    'confirmation_details' => 'Nous avons envoyé un email de confirmation à votre adresse email.',
    'return_home' => 'Retour à l\'accueil',

    // Options scolaires
    'study_options' => [
        'Aides-Soignantes',
        'Arts et métiers',
        'Commerciale',
        'Coupe & Couture',
        'Electricité',
        'Electronique',
        'Littéraire',
        'Mécanique',
        'Pédagogie',
        'Scientifique',
        'Secrétariat',
        'Autre (Veuillez spécifier)'
    ],

    // Filieres universitaires
    'university_fields' => [
        'Sciences et Technologies' => [
            'Génie Civil',
            'Génie Mécanique',
            'Génie Électrique',
            'Génie Logiciel',
            'Génie Informatique',
            'Génie Chimique',
            'Génie des Télécommunications',
            'Mathématiques Appliquées',
            'Physique',
            'Chimie',
            'Biologie',
            'Géologie',
            'Sciences Environnementales',
        ],
        'Sciences Économiques et de Gestion' => [
            'Sciences Économiques',
            'Sciences de Gestion',
            'Gestion des Entreprises',
            'Gestion des Ressources Humaines',
            'Marketing',
            'Comptabilité et Finance',
            'Banque et Finance',
            'Assurances',
        ],
        'Droit' => [
            'Droit Privé et Judiciaire',
            'Droit Public',
            'Droit International',
            'Droit Économique',
        ],
        'Médecine et Santé' => [
            'Médecine Générale',
            'Dentisterie',
            'Pharmacie',
            'Sciences Infirmières',
            'Santé Publique',
        ],
        'Lettres et Sciences Humaines' => [
            'Philosophie',
            'Histoire',
            'Sociologie',
            'Psychologie',
            'Sciences Politiques',
            'Relations Internationales',
        ],
        'Agronomie' => [
            'Agronomie Générale',
            'Sciences Vétérinaires',
            'Sciences et Techniques de Développement',
        ],
        'Autre' => 'Autre (veuillez préciser)'
    ]
];
