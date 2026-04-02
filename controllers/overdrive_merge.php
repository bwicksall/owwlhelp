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
    $subject = 'OWWL Help - OverDrive Account Merge';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    try {
        $message = render_email_template('overdrive_merge', [
            'requester_email' => $requester_email,
            'requester_library' => $requester_library,
            'requester_notes' => optional_value($requester_notes),
            'od_patron_last_name' => $od_patron_last_name,
            'od_new_card_number' => $od_new_card_number,
        ]);
    } catch (RuntimeException $e) {
        $errors[] = 'Email template configuration error. Please contact support.';
    }

    $mail_sent = !$errors ? @mail($overdrive_email, $subject, $message, $headers) : false;

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
