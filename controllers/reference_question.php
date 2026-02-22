<?php

$ref_request_type = post_value('ref_request_type', $ref_request_type);
$ref_subject_topic = post_value('ref_subject_topic', $ref_subject_topic);
$ref_sources_consulted = post_value('ref_sources_consulted', $ref_sources_consulted);
$ref_notes_comments = post_value('ref_notes_comments', $ref_notes_comments);

$allowed_request_types = ['Information', 'Subject', 'Training', 'Other'];
if ($ref_request_type === '' || !in_array($ref_request_type, $allowed_request_types, true)) {
    $errors[] = 'Please select a valid request type.';
}

if (!$errors) {
    $lines = [
        'Ticket Type: Ask a Reference Question',
        "Requester Email: {$requester_email}",
        "Library: {$requester_library}",
        "Request Type: {$ref_request_type}",
        'Subject or Topic: ' . ($ref_subject_topic !== '' ? $ref_subject_topic : 'None'),
        'Sources Consulted: ' . ($ref_sources_consulted !== '' ? $ref_sources_consulted : 'None'),
        'Notes or Comments: ' . ($ref_notes_comments !== '' ? $ref_notes_comments : 'None'),
    ];

    $subject = 'OWWL Help - Ask a Reference Question';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    $message = implode("\n", $lines);

    $mail_sent = @mail($reference_email, $subject, $message, $headers);

    if ($mail_sent) {
        $success_message = 'Your request has been sent.';
        $requester_library = '';
        $ref_request_type = '';
        $ref_subject_topic = '';
        $ref_sources_consulted = '';
        $ref_notes_comments = '';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
