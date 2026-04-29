<?php

$oc_title = post_value('oc_title');
$oc_isbn_upc = post_value('oc_isbn_upc');
$oc_need_by_date = post_value('oc_need_by_date');
$oc_material_type = post_value('oc_material_type');

$allowed_material_types = ['Book', 'Audiobook', 'Musical recording', 'Video recording', 'Video game', 'Realia'];
if ($oc_title === '') {
    $errors[] = 'Please enter the title.';
}
if ($oc_need_by_date === '') {
    $errors[] = 'Please enter the record need-by date.';
}
if (!in_array($oc_material_type, $allowed_material_types, true)) {
    $errors[] = 'Please select a valid material type.';
}

$oc_fields = [];
$required_by_type = [];

if ($oc_material_type === 'Book') {
    $oc_fields = [
        'Author' => post_value('oc_book_author'),
        'Illustrator' => post_value('oc_book_illustrator'),
        'Editor' => post_value('oc_book_editor'),
        'Translator' => post_value('oc_book_translator'),
        'Publication information' => post_value('oc_book_publication_info'),
        'Copyright' => post_value('oc_book_copyright'),
        'Physical description' => post_value('oc_book_physical_description'),
        'Intended audience' => post_value('oc_book_intended_audience'),
        'Format' => post_value('oc_book_format'),
        'Summary' => post_value('oc_book_summary'),
        'Additional information' => post_value('oc_book_additional_information'),
    ];
    $required_by_type = ['Publication information', 'Copyright', 'Physical description', 'Intended audience', 'Format', 'Summary'];
} elseif ($oc_material_type === 'Audiobook') {
    $oc_fields = [
        'Author' => post_value('oc_audiobook_author'),
        'Abridged or Unabridged' => post_value('oc_audiobook_abridged_unabridged'),
        'Format' => post_value('oc_audiobook_format'),
        'Physical description' => post_value('oc_audiobook_physical_description'),
        'Publication information' => post_value('oc_audiobook_publication_info'),
        'Copyright or Phonogram date' => post_value('oc_audiobook_copyright_phonogram'),
        'Narrator(s)' => post_value('oc_audiobook_narrators'),
        'Playing time' => post_value('oc_audiobook_playing_time'),
        'Additional information' => post_value('oc_audiobook_additional_information'),
        'Intended audience' => post_value('oc_audiobook_intended_audience'),
        'Summary' => post_value('oc_audiobook_summary'),
    ];
    $required_by_type = ['Abridged or Unabridged', 'Format', 'Physical description', 'Publication information', 'Copyright or Phonogram date', 'Intended audience', 'Summary'];
} elseif ($oc_material_type === 'Musical recording') {
    $oc_fields = [
        'Performer(s)' => post_value('oc_music_performers'),
        'Publication information' => post_value('oc_music_publication_info'),
        'Explicit or Edited version' => post_value('oc_music_explicit_or_edited'),
        'Physical description' => post_value('oc_music_physical_description'),
        'Copyright or Phonogram date' => post_value('oc_music_copyright_phonogram'),
        'Playing time' => post_value('oc_music_playing_time'),
        'Playlist' => post_value('oc_music_playlist'),
        'Form of music' => post_value('oc_music_form'),
        'Intended audience' => post_value('oc_music_intended_audience'),
    ];
    $required_by_type = ['Publication information', 'Physical description', 'Copyright or Phonogram date', 'Form of music'];
} elseif ($oc_material_type === 'Video recording') {
    $oc_fields = [
        'Format' => post_value('oc_video_format'),
        'Publisher number' => post_value('oc_video_publisher_number'),
        'Publication information' => post_value('oc_video_publication_info'),
        'Copyright date' => post_value('oc_video_copyright_date'),
        'Physical description' => post_value('oc_video_physical_description'),
        'Full screen or wide screen' => post_value('oc_video_screen'),
        'Form of work' => post_value('oc_video_form_of_work'),
        'Rating and reason' => post_value('oc_video_rating_reason'),
        'Director(s)' => post_value('oc_video_directors'),
        'Producer(s)' => post_value('oc_video_producers'),
        'Actor(s)' => post_value('oc_video_actors'),
        'Language(s) of dialogue and subtitles' => post_value('oc_video_languages'),
        'Additional information' => post_value('oc_video_additional_information'),
        'Summary' => post_value('oc_video_summary'),
    ];
    $required_by_type = ['Format', 'Publication information', 'Physical description', 'Form of work', 'Summary'];
} elseif ($oc_material_type === 'Video game') {
    $oc_fields = [
        'Gaming platform' => post_value('oc_game_platform'),
        'Publisher number' => post_value('oc_game_publisher_number'),
        'Publication information' => post_value('oc_game_publication_info'),
        'Copyright date' => post_value('oc_game_copyright_date'),
        'Physical description' => post_value('oc_game_physical_description'),
        'Rating or recommended age level' => post_value('oc_game_rating_age'),
        'Summary' => post_value('oc_game_summary'),
    ];
    $required_by_type = ['Gaming platform', 'Publication information', 'Physical description', 'Summary'];
} elseif ($oc_material_type === 'Realia') {
    $oc_fields = [
        'Year manufactured or assembled' => post_value('oc_realia_year_manufactured'),
        'Who made this' => post_value('oc_realia_who_made'),
        'Manufacturer information' => post_value('oc_realia_manufacturer_information'),
        'Contents' => post_value('oc_realia_contents'),
        'Size of container/box' => post_value('oc_realia_container_size'),
        'Contents list' => post_value('oc_realia_contents_list'),
        'Associated ISBNs or UPCs' => post_value('oc_realia_associated_isbns_upcs'),
    ];
    $required_by_type = ['Year manufactured or assembled', 'Who made this', 'Contents', 'Size of container/box'];
}

foreach ($required_by_type as $required_label) {
    if (($oc_fields[$required_label] ?? '') === '') {
        $errors[] = "Please enter {$required_label}.";
    }
}

if (!$errors) {
    $lines = [
        "Title: {$oc_title}",
        "Material type: {$oc_material_type}",
    ];
    if ($oc_isbn_upc !== '') {
        $lines[] = "ISBN or UPC: {$oc_isbn_upc}";
    }
    if ($oc_need_by_date !== '') {
        $lines[] = "Record need-by date: {$oc_need_by_date}";
    }
    foreach ($oc_fields as $label => $value) {
        if ($value !== '') {
            $lines[] = "{$label}: {$value}";
        }
    }

    $subject = 'OWWL Help - Request original cataloging';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    try {
        $message = render_email_template('original_cataloging', [
            'requester_email' => $requester_email,
            'requester_library' => $requester_library,
            'field_lines' => implode("\n", $lines),
        ]);
    } catch (RuntimeException $e) {
        $errors[] = 'Email template configuration error. Please contact support.';
    }

    $mail_sent = !$errors ? @mail($originalcataloging_email, $subject, $message, $headers) : false;

    if ($mail_sent) {
        $success_message = 'Your request has been sent.';
        $requester_library = '';
        foreach (array_keys($_POST) as $key) {
            if (strpos($key, 'oc_') === 0) {
                unset($_POST[$key]);
            }
        }
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
