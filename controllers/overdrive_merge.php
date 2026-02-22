<?php

$od_patron_last_name = post_value('od_patron_last_name', $od_patron_last_name);
$od_new_card_number = post_value('od_new_card_number', $od_new_card_number);

if ($od_patron_last_name === '') {
    $errors[] = 'Please enter the patron last name.';
}
if ($od_new_card_number === '') {
    $errors[] = 'Please enter the new library card number.';
}

if (!$errors) {
    $lines = [
        'Ticket Type: Overdrive Account Merge',
        "Requester Email: {$requester_email}",
        "Library: {$requester_library}",
    ];
    if ($requester_notes !== '') {
        $lines[] = "Requester Notes: {$requester_notes}";
    }
    $lines[] = "Patron Last Name: {$od_patron_last_name}";
    $lines[] = "New Library Card Number: {$od_new_card_number}";

    $subject = 'OWWL Help - Overdrive Account Merge';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    $message = implode("\n", $lines);

    $mail_sent = @mail($overdrive_email, $subject, $message, $headers);

    if ($mail_sent) {
        $success_message = 'Your request has been sent.';
        $requester_library = '';
        $requester_notes = '';
        $od_patron_last_name = '';
        $od_new_card_number = '';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
