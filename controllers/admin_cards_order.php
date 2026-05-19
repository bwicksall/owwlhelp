<?php

function normalize_qty(string $value): string {
    $trimmed = trim($value);
    if ($trimmed === '') {
        return '0';
    }
    if (!ctype_digit($trimmed)) {
        return $trimmed;
    }
    return (string) ((int) $trimmed);
}

$ac_library_cards = normalize_qty(post_value('ac_library_cards', $ac_library_cards));
$ac_keytags = normalize_qty(post_value('ac_keytags', $ac_keytags));
$ac_card_keytag_combos = normalize_qty(post_value('ac_card_keytag_combos', $ac_card_keytag_combos));
$ac_booklet_library_cards = normalize_qty(post_value('ac_booklet_library_cards', $ac_booklet_library_cards));
$ac_booklet_keytags = normalize_qty(post_value('ac_booklet_keytags', $ac_booklet_keytags));
$ac_booklet_card_keytag_combos = normalize_qty(post_value('ac_booklet_card_keytag_combos', $ac_booklet_card_keytag_combos));
$ac_additional_comments = post_value('ac_additional_comments', $ac_additional_comments);

$qty_fields = [
    'Library cards' => $ac_library_cards,
    'Keytags' => $ac_keytags,
    'Card / keytag combos' => $ac_card_keytag_combos,
    'Booklet library cards' => $ac_booklet_library_cards,
    'Booklet keytags' => $ac_booklet_keytags,
    'Booklet card / keytag combos' => $ac_booklet_card_keytag_combos,
];

foreach ($qty_fields as $label => $value) {
    if (!ctype_digit($value)) {
        $errors[] = "Please enter a whole number for {$label}.";
    }
}

if (!$errors) {
    $subject = 'OWWL Help - Library card & keytag order';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    try {
        $message = render_email_template('admin_cards_order', [
            'requester_email' => $requester_email,
            'requester_library' => $requester_library,
            'ac_library_cards' => $ac_library_cards,
            'ac_keytags' => $ac_keytags,
            'ac_card_keytag_combos' => $ac_card_keytag_combos,
            'ac_booklet_library_cards' => $ac_booklet_library_cards,
            'ac_booklet_keytags' => $ac_booklet_keytags,
            'ac_booklet_card_keytag_combos' => $ac_booklet_card_keytag_combos,
            'ac_additional_comments' => optional_value($ac_additional_comments),
        ]);
    } catch (RuntimeException $e) {
        $errors[] = 'Email template configuration error. Please contact support.';
    }

    $mail_sent = !$errors ? @mail($admin_cards, $subject, $message, $headers) : false;

    if ($mail_sent) {
        $success_message = 'Your request has been sent.';
        $requester_library = '';
        $ac_library_cards = '0';
        $ac_keytags = '0';
        $ac_card_keytag_combos = '0';
        $ac_booklet_library_cards = '0';
        $ac_booklet_keytags = '0';
        $ac_booklet_card_keytag_combos = '0';
        $ac_additional_comments = '';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
