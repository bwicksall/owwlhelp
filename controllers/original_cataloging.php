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
    $subject = 'OWWL Help - Request original cataloging';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    try {
        $message = render_email_template('original_cataloging', [
            'requester_email' => $requester_email,
            'requester_library' => $requester_library,
            'oc_title_subtitle' => $oc_title_subtitle,
            'oc_material_type' => $oc_material_type,
            'oc_genre_category' => $oc_genre_category,
            'oc_physical_description' => $oc_physical_description,
            'oc_summary' => $oc_summary,
            'oc_format' => optional_value($oc_format),
            'oc_additional_format_info' => optional_value($oc_additional_format_info),
            'oc_author' => optional_value($oc_author),
            'oc_publisher_manufacturer' => optional_value($oc_publisher_manufacturer),
            'oc_year_details' => optional_value($oc_year_details),
            'oc_need_by_date' => optional_value($oc_need_by_date),
            'oc_additional_material_details' => optional_value($oc_additional_material_details),
            'oc_additional_comments' => optional_value($oc_additional_comments),
            'oc_isbn_upc' => optional_value($oc_isbn_upc),
        ]);
    } catch (RuntimeException $e) {
        $errors[] = 'Email template configuration error. Please contact support.';
    }

    $mail_sent = !$errors ? @mail($originalcataloging_email, $subject, $message, $headers) : false;

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
