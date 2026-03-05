<?php

$ts_subject = post_value('ts_subject', $ts_subject);
$ts_description = post_value('ts_description', $ts_description);

if ($ts_subject === '') {
    $errors[] = 'Please enter the subject.';
}
if ($ts_description === '') {
    $errors[] = 'Please enter the description.';
}

if (!$errors) {
    $subject = 'OWWL Help - General Support';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    try {
        $message = render_email_template('general_support', [
            'requester_email' => $requester_email,
            'requester_library' => $requester_library,
            'ts_subject' => $ts_subject,
            'ts_description' => $ts_description,
        ]);
    } catch (RuntimeException $e) {
        $errors[] = 'Email template configuration error. Please contact support.';
    }

    $mail_sent = !$errors ? @mail($primary_email, $subject, $message, $headers) : false;

    if ($mail_sent) {
        $success_message = 'Your request has been sent.';
        $requester_library = '';
        $ts_subject = '';
        $ts_description = '';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
