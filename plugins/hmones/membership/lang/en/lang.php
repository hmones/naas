<?php return [
    'plugin' => [
        'name' => 'Membership',
        'description' => 'The plugin is for managing NAAS membership forms and applications'
    ],
    'messages' => [
        'resetSuccess' => 'Password Reset Successfully!!',
        'emailSent' => 'Check your email for password reset code!',
        'profileUpdated' => 'Profile updated successfully!',
        'emptyNameEmail' => 'Name or email can not be empty!',
        'applicationSaved' => 'Application Saved Successfully!',
        'applicationSubmitted' => 'Application has been submitted successfully!',
        'applicationAlreadySubmitted' => 'We received your application for this round, it can not be modified',
        'roundNotExist' => 'This application round does not exist!',
        'roundNotActive' => 'The application round is not currently active',
        'applicationPrefilled' => 'Application is currently prefilled with previous responses and saved!'

    ],
    'ApplicationStatus' => [
        'status_0' => 'Draft',
        'status_1' => 'Submitted',
        'status_2' => 'In Review',
        'status_3' => 'Accepted',
        'status_4' => 'Rejected'
    ]
];