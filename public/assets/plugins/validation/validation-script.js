$(document).ready(function () {

    $("#jQueryValidationForm").validate({
        rules: {
            nom: {
                required: true,
                maxlength: 255
            },
            postnom: {
                required: true,
                maxlength: 255
            },
            prenom: {
                required: true,
                maxlength: 255
            },
            genre: {
                required: true,
            },
            etat_civil: "required",
            nationalite: {
                required: true,
                maxlength: 255
            },
            date_naissance: {
                required: true,
                date: true // Assurez-vous que c'est une date valide
            },
            adresse_physique: {
                required: true,
            },
            telephone: {
                required: true,
                maxlength: 20
            },
            date_embauche: {
                required: true,
                date: true // Assurez-vous que c'est une date valide
            },
            salaire: {
                required: true,
                number: true // Assurez-vous que c'est un nombre
            },
            poste: {
                required: true,
                maxlength: 255
            },
            departement_id: {
                required: true
            }
        },
        messages: {
            nom: {
                required: "Veuillez entrer le nom de l'employé",
                maxlength: "Le nom ne doit pas dépasser 255 caractères"
            },
            postnom: {
                required: "Veuillez entrer le postnom de l'employé",
                maxlength: "Le postnom ne doit pas dépasser 255 caractères"
            },
            prenom: {
                required: "Veuillez entrer le prénom de l'employé",
                maxlength: "Le prénom ne doit pas dépasser 255 caractères"
            },
            genre: {
                required: "Veuillez sélectionner le genre de l'employé",
                in: "Le genre doit être 'homme' ou 'femme'"
            },
            etat_civil: "Veuillez sélectionner l'état civil de l'employé",
            nationalite: {
                required: "Veuillez entrer la nationalité de l'employé",
                maxlength: "La nationalité ne doit pas dépasser 255 caractères"
            },
            date_naissance: {
                required: "Veuillez entrer la date de naissance de l'employé",
                date: "Veuillez entrer une date valide"
            },
            adresse_physique: "Veuillez entrer l'adresse physique de l'employé",
            telephone: {
                required: "Veuillez entrer le numéro de téléphone de l'employé",
                maxlength: "Le numéro de téléphone ne doit pas dépasser 20 caractères"
            },
            date_embauche: {
                required: "Veuillez entrer la date d'embauche de l'employé",
                date: "Veuillez entrer une date valide"
            },
            salaire: {
                required: "Veuillez entrer le salaire de l'employé",
                number: "Veuillez entrer un nombre valide"
            },
            poste: {
                required: "Veuillez entrer le poste de l'employé",
                maxlength: "Le poste ne doit pas dépasser 255 caractères"
            },
            departement_id: "Veuillez sélectionner un département pour l'employé"
        },
    });




});
