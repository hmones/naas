<?php return [
    'plugin' => [
        'name' => 'Membership',
        'description' => 'The plugin is for managing NAAS membership forms and applications'
    ],
    'messages' => [
        'resetSuccess' => 'Password reset successfully',
        'emailSent' => 'Check your email for password reset code',
        'profileUpdated' => 'Profile updated successfully',
        'emptyNameEmail' => 'Name or email can not be empty',
        'applicationSaved' => 'Form saved successfully',
        'applicationSubmitted' => 'Membership form has been submitted successfully',
        'applicationAlreadySubmitted' => 'We received your membership form for this round, it can no longer be modified. Please reach out to the NAAS team on membership@naasnetwork.org for any modifications.',
        'roundNotExist' => 'The application round does not exist',
        'roundNotActive' => 'The application round is not currently active',
        'applicationPrefilled' => 'Membership form is currently prefilled with previous responses and saved. Please make the necessary changes to reflect this year`s data.'

    ],
    'ApplicationStatus' => [
        'status_0' => 'Draft',
        'status_1' => 'Submitted',
        'status_2' => 'In Review',
        'status_3' => 'Accepted',
        'status_4' => 'Rejected'
    ]
];