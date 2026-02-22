<?php

$oc_title_subtitle = post_value('oc_title_subtitle', $oc_title_subtitle);
$oc_material_type = post_value('oc_material_type', $oc_material_type);
$oc_genre_category = post_value('oc_genre_category', $oc_genre_category);
$oc_physical_description = post_value('oc_physical_description', $oc_physical_description);
$oc_summary = post_value('oc_summary', $oc_summary);
$oc_format = post_value('oc_format', $oc_format);
$oc_additional_format_info = post_value('oc_additional_format_info', $oc_additional_format_info);
$oc_author = post_value('oc_author', $oc_author);
$oc_publisher_manufacturer = post_value('oc_publisher_manufacturer', $oc_publisher_manufacturer);
$oc_year_details = post_value('oc_year_details', $oc_year_details);
$oc_need_by_date = post_value('oc_need_by_date', $oc_need_by_date);
$oc_additional_material_details = post_value('oc_additional_material_details', $oc_additional_material_details);
$oc_additional_comments = post_value('oc_additional_comments', $oc_additional_comments);
$oc_isbn_upc = post_value('oc_isbn_upc', $oc_isbn_upc);

$allowed_material_types = ['Book', 'Audiobook', 'Music CD', 'Video', 'Video game', 'Realia', 'Other'];
$allowed_genres = ['Fiction', 'Nonfiction', 'Poetry', 'Biography', 'Other', 'Not applicable'];
$allowed_formats = ['Large Print', 'Regular Print', 'Unabridged', 'Abridged', 'DVD', 'Blu-ray', '4K UHD', 'Nintendo Switch', 'PlayStation 4', 'PlayStation 5', 'Xbox One', 'Xbox Series X', 'Other (please specify in additional comments below)'];
$allowed_additional_format_info = ['VOX book', 'Playaway', 'Other (please specify in additional comments below)'];

if ($oc_title_subtitle === '') {
    $errors[] = 'Please enter title and subtitle.';
}
if ($oc_material_type === '' || !in_array($oc_material_type, $allowed_material_types, true)) {
    $errors[] = 'Please select a valid material type.';
}
if ($oc_genre_category === '' || !in_array($oc_genre_category, $allowed_genres, true)) {
    $errors[] = 'Please select a valid genre or category.';
}
if ($oc_physical_description === '') {
    $errors[] = 'Please enter physical description.';
}
if ($oc_summary === '') {
    $errors[] = 'Please enter summary.';
}
if ($oc_format !== '' && !in_array($oc_format, $allowed_formats, true)) {
    $errors[] = 'Please select a valid format.';
}
if ($oc_additional_format_info !== '' && !in_array($oc_additional_format_info, $allowed_additional_format_info, true)) {
    $errors[] = 'Please select valid additional format information.';
}

if (!$errors) {
    $lines = [
        'Ticket Type: Request Original Cataloging',
        "Requester Email: {$requester_email}",
        "Library: {$requester_library}",
        "Title and Subtitle: {$oc_title_subtitle}",
        "Material Type: {$oc_material_type}",
        "Genre or Category: {$oc_genre_category}",
        "Physical Description: {$oc_physical_description}",
        "Summary: {$oc_summary}",
        'Format: ' . ($oc_format !== '' ? $oc_format : 'None'),
        'Additional Format Information: ' . ($oc_additional_format_info !== '' ? $oc_additional_format_info : 'None'),
        'Author: ' . ($oc_author !== '' ? $oc_author : 'None'),
        'Publisher or Manufacturer: ' . ($oc_publisher_manufacturer !== '' ? $oc_publisher_manufacturer : 'None'),
        'Year Details: ' . ($oc_year_details !== '' ? $oc_year_details : 'None'),
        'Record Need-by Date: ' . ($oc_need_by_date !== '' ? $oc_need_by_date : 'None'),
        'Additional Material Type Details: ' . ($oc_additional_material_details !== '' ? $oc_additional_material_details : 'None'),
        'Additional Comments: ' . ($oc_additional_comments !== '' ? $oc_additional_comments : 'None'),
        'ISBN or UPC: ' . ($oc_isbn_upc !== '' ? $oc_isbn_upc : 'None'),
    ];

    $subject = 'OWWL Help - Request Original Cataloging';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    $message = implode("\n", $lines);

    $mail_sent = @mail($originalcataloging_email, $subject, $message, $headers);

    if ($mail_sent) {
        $success_message = 'Your request has been sent.';
        $requester_library = '';
        $oc_title_subtitle = '';
        $oc_material_type = '';
        $oc_genre_category = '';
        $oc_physical_description = '';
        $oc_summary = '';
        $oc_format = '';
        $oc_additional_format_info = '';
        $oc_author = '';
        $oc_publisher_manufacturer = '';
        $oc_year_details = '';
        $oc_need_by_date = '';
        $oc_additional_material_details = '';
        $oc_additional_comments = '';
        $oc_isbn_upc = '';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
