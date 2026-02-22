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
    $lines = [
        'Ticket Type: Request a CBA Purchase',
        "Requester Email: {$requester_email}",
        "Library: {$requester_library}",
        'Author: ' . ($cba_author !== '' ? $cba_author : 'None'),
        "Title: {$cba_title}",
        'Publisher: ' . ($cba_publisher !== '' ? $cba_publisher : 'None'),
        'Year: ' . ($cba_year !== '' ? $cba_year : 'None'),
        'ISBN: ' . ($cba_isbn !== '' ? $cba_isbn : 'None'),
        'Subject or Topic: ' . ($cba_subject_topic !== '' ? $cba_subject_topic : 'None'),
        'Citation Source: ' . ($cba_citation_source !== '' ? $cba_citation_source : 'None'),
        'Notes or Comments: ' . ($cba_notes_comments !== '' ? $cba_notes_comments : 'None'),
        'Format: ' . ($cba_format !== '' ? $cba_format : 'None'),
    ];

    $subject = 'OWWL Help - Request a CBA Purchase';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    $message = implode("\n", $lines);

    $mail_sent = @mail($gpldirector_email, $subject, $message, $headers);

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
