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
    $subject = 'OWWL Help - Ask a Reference Question';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    try {
        $message = render_email_template('reference_question', [
            'requester_email' => $requester_email,
            'requester_library' => $requester_library,
            'ref_request_type' => $ref_request_type,
            'ref_subject_topic' => optional_value($ref_subject_topic),
            'ref_sources_consulted' => optional_value($ref_sources_consulted),
            'ref_notes_comments' => optional_value($ref_notes_comments),
        ]);
    } catch (RuntimeException $e) {
        $errors[] = 'Email template configuration error. Please contact support.';
    }

    $mail_sent = !$errors ? @mail($reference_email, $subject, $message, $headers) : false;

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
