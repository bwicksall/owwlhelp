<?php

$cba_author = post_value('cba_author', $cba_author);
$cba_title = post_value('cba_title', $cba_title);
$cba_publisher = post_value('cba_publisher', $cba_publisher);
$cba_year = post_value('cba_year', $cba_year);
$cba_isbn = post_value('cba_isbn', $cba_isbn);
$cba_subject_topic = post_value('cba_subject_topic', $cba_subject_topic);
$cba_citation_source = post_value('cba_citation_source', $cba_citation_source);
$cba_notes_comments = post_value('cba_notes_comments', $cba_notes_comments);
$cba_format = post_value('cba_format', $cba_format);

$allowed_formats = [
    'Book',
    'Large Print',
    'Audiobook-Cassette',
    'Audiobook-CD',
    'Video-DVD',
    'Video-Bluray',
    'OverDrive eBook',
    'OverDrive Audiobook',
];

if ($cba_title === '') {
    $errors[] = 'Please enter the title.';
}
if ($cba_format !== '' && !in_array($cba_format, $allowed_formats, true)) {
    $errors[] = 'Please select a valid format.';
}

if (!$errors) {
    $subject = 'OWWL Help - Request a CBA Purchase';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    try {
        $message = render_email_template('cba_purchase', [
            'requester_email' => $requester_email,
            'requester_library' => $requester_library,
            'cba_author' => optional_value($cba_author),
            'cba_title' => $cba_title,
            'cba_publisher' => optional_value($cba_publisher),
            'cba_year' => optional_value($cba_year),
            'cba_isbn' => optional_value($cba_isbn),
            'cba_subject_topic' => optional_value($cba_subject_topic),
            'cba_citation_source' => optional_value($cba_citation_source),
            'cba_notes_comments' => optional_value($cba_notes_comments),
            'cba_format' => optional_value($cba_format),
        ]);
    } catch (RuntimeException $e) {
        $errors[] = 'Email template configuration error. Please contact support.';
    }

    $mail_sent = !$errors ? @mail($gpldirector_email, $subject, $message, $headers) : false;

    if ($mail_sent) {
        $success_message = 'Your request has been sent.';
        $requester_library = '';
        $cba_author = '';
        $cba_title = '';
        $cba_publisher = '';
        $cba_year = '';
        $cba_isbn = '';
        $cba_subject_topic = '';
        $cba_citation_source = '';
        $cba_notes_comments = '';
        $cba_format = '';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
