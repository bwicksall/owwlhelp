<?php

$eg_issue = post_value('eg_issue', $eg_issue);

if ($eg_issue === '') {
    $errors[] = 'Please enter the issue details.';
}

if (!$errors) {
    $subject = 'OWWL Help - Evergreen and Aspen support request';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    try {
        $message = render_email_template('evergreen_issue', [
            'requester_email' => $requester_email,
            'requester_library' => $requester_library,
            'eg_issue' => $eg_issue,
        ]);
    } catch (RuntimeException $e) {
        $errors[] = 'Email template configuration error. Please contact support.';
    }

    $mail_sent = !$errors ? @mail($evergreen_email, $subject, $message, $headers) : false;

    if ($mail_sent) {
        $success_message = 'Your request has been sent.';
        $requester_library = '';
        $eg_issue = '';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
