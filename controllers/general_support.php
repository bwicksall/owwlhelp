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
    $lines = [
        'Ticket Type: General Support',
        "Requester Email: {$requester_email}",
        "Library: {$requester_library}",
        "Subject: {$ts_subject}",
        "Description: {$ts_description}",
    ];

    $subject = 'OWWL Help - General Support';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    $message = implode("\n", $lines);

    $mail_sent = @mail($primary_email, $subject, $message, $headers);

    if ($mail_sent) {
        $success_message = 'Your request has been sent.';
        $requester_library = '';
        $ts_subject = '';
        $ts_description = '';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
