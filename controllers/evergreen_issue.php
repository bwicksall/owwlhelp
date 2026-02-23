<?php

$eg_problem_type = post_value('eg_problem_type', $eg_problem_type);
$eg_issue = post_value('eg_issue', $eg_issue);

$allowed_problem_types = [
    'Bills',
    'Circulation',
    'Fines',
    'Holdings Maintenance',
    'Holds',
    'Network Errors',
    'Notifications',
    'OPAC',
    'Overdues',
    'Printing',
    'Reports',
    'Staff Client (general)',
    'Web Client',
    'Other (Specify in the "Issue" box)',
];

if ($eg_problem_type === '' || !in_array($eg_problem_type, $allowed_problem_types, true)) {
    $errors[] = 'Please select a valid problem type.';
}
if ($eg_issue === '') {
    $errors[] = 'Please enter the issue details.';
}

if (!$errors) {
    $lines = [
        'Ticket Type: Report an Evergreen Issue',
        "Requester Email: {$requester_email}",
        "Library: {$requester_library}",
        "Problem Type: {$eg_problem_type}",
        "Issue: {$eg_issue}",
    ];

    $subject = 'OWWL Help - Report an Evergreen Issue';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    $message = implode("\n", $lines);

    $mail_sent = @mail($evergreen_email, $subject, $message, $headers);

    if ($mail_sent) {
        $success_message = 'Your request has been sent.';
        $requester_library = '';
        $eg_problem_type = '';
        $eg_issue = '';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
