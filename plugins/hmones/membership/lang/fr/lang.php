<?php return [
    'plugin' => [
        'name' => 'Membership',
        'description' => 'The plugin is for managing NAAS membership forms and applications'
    ],
    'messages' => [
        'resetSuccess' => 'Réinitialisation du mot de passe réussie',
        'emailSent' => 'Vérifiez votre email pour le code de réinitialisation du mot de passe',
        'profileUpdated' => 'Mise à jour du profil réussie',
        'emptyNameEmail' => 'Le nom ou l`adresse électronique ne peuvent pas être vides',
        'applicationSaved' => 'Formulaire sauvegardé avec succès',
        'applicationSubmitted' => "Le formulaire d'adhésion a été soumis avec succès",
        'applicationAlreadySubmitted' => "Nous avons reçu votre formulaire d'adhésion pour ce cycle, il ne peut être modifié. Prière d'écrire à l'équipe NAAS sur membership@naasnetwork.org pour toute modification à votre formulaire d'adhésion",
        'roundNotExist' => "Le cycle de candidature n'existe pas",
        'roundNotActive' => "Le cycle de candidature n'est pas actif actuellement",
        'applicationPrefilled' => "Le formulaire d'adhésion est actuellement pré-rempli avec les réponses précédentes et sauvegardé. Veuillez apporter les modifications nécessaires pour fournir les données de cette année."

    ],
    'ApplicationStatus' => [
        'status_0' => 'Draft',
        'status_1' => 'Submitted',
        'status_2' => 'In Review',
        'status_3' => 'Accepted',
        'status_4' => 'Rejected'
    ]
];