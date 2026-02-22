<?php

$cat_problem = post_value('cat_problem', $cat_problem);
$cat_material_type = post_value('cat_material_type', $cat_material_type);
$cat_format = post_value('cat_format', $cat_format);
$cat_description = post_value('cat_description', $cat_description);
$cat_author = post_value('cat_author', $cat_author);
$cat_title = post_value('cat_title', $cat_title);
$cat_publisher = post_value('cat_publisher', $cat_publisher);
$cat_year = post_value('cat_year', $cat_year);
$cat_isbn_ups = post_value('cat_isbn_ups', $cat_isbn_ups);
$cat_additional_comments = post_value('cat_additional_comments', $cat_additional_comments);

$allowed_problems = ['Title Error', 'Add ISBN or UPC', 'Page and CM', 'Replace Record', 'Merge Record', 'Field Error', 'Other'];
$allowed_material_types = ['Book', 'CD', 'DVD', 'Other'];
$allowed_formats = ['Large Print', 'Regular Print', 'Unabridged', 'Abridged', 'Widescreen', 'Full Screen', 'Other'];

if ($cat_problem === '' || !in_array($cat_problem, $allowed_problems, true)) {
    $errors[] = 'Please select a valid problem type.';
}
if ($cat_material_type !== '' && !in_array($cat_material_type, $allowed_material_types, true)) {
    $errors[] = 'Please select a valid material type.';
}
if ($cat_format !== '' && !in_array($cat_format, $allowed_formats, true)) {
    $errors[] = 'Please select a valid format.';
}
if ($cat_description === '') {
    $errors[] = 'Please enter the description.';
}

if (!$errors) {
    $lines = [
        'Ticket Type: Report a Catalog Issue',
        "Requester Email: {$requester_email}",
        "Library: {$requester_library}",
        "Problem: {$cat_problem}",
        'Material Type: ' . ($cat_material_type !== '' ? $cat_material_type : 'None'),
        'Format: ' . ($cat_format !== '' ? $cat_format : 'None'),
        "Description: {$cat_description}",
        'Author: ' . ($cat_author !== '' ? $cat_author : 'None'),
        'Title: ' . ($cat_title !== '' ? $cat_title : 'None'),
        'Publisher: ' . ($cat_publisher !== '' ? $cat_publisher : 'None'),
        'Year: ' . ($cat_year !== '' ? $cat_year : 'None'),
        'ISBN or UPS: ' . ($cat_isbn_ups !== '' ? $cat_isbn_ups : 'None'),
        'Additional Comments: ' . ($cat_additional_comments !== '' ? $cat_additional_comments : 'None'),
    ];

    $subject = 'OWWL Help - Report a Catalog Issue';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    $message = implode("\n", $lines);

    $mail_sent = @mail($cataloging_email, $subject, $message, $headers);

    if ($mail_sent) {
        $success_message = 'Your request has been sent.';
        $requester_library = '';
        $cat_problem = '';
        $cat_material_type = '';
        $cat_format = '';
        $cat_description = '';
        $cat_author = '';
        $cat_title = '';
        $cat_publisher = '';
        $cat_year = '';
        $cat_isbn_ups = '';
        $cat_additional_comments = '';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
