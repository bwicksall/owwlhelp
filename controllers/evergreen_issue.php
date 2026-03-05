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
    $subject = 'OWWL Help - Report an Evergreen Issue';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    try {
        $message = render_email_template('evergreen_issue', [
            'requester_email' => $requester_email,
            'requester_library' => $requester_library,
            'eg_problem_type' => $eg_problem_type,
            'eg_issue' => $eg_issue,
        ]);
    } catch (RuntimeException $e) {
        $errors[] = 'Email template configuration error. Please contact support.';
    }

    $mail_sent = !$errors ? @mail($evergreen_email, $subject, $message, $headers) : false;

    if ($mail_sent) {
        $success_message = 'Your request has been sent.';
        $requester_library = '';
        $eg_problem_type = '';
        $eg_issue = '';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
