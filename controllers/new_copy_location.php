<?php

$ecl_location_name = post_value('ecl_location_name', $ecl_location_name);
$ecl_opac_visible = post_value('ecl_opac_visible', $ecl_opac_visible);
$ecl_holdable = post_value('ecl_holdable', $ecl_holdable);
$ecl_circulate = post_value('ecl_circulate', $ecl_circulate);
$ecl_additional_comments = post_value('ecl_additional_comments', $ecl_additional_comments);

if ($ecl_location_name === '') {
    $errors[] = 'Please enter the location name.';
}
if (!valid_yes_no($ecl_opac_visible)) {
    $errors[] = 'Please select OPAC Visible as Yes or No.';
}
if (!valid_yes_no($ecl_holdable)) {
    $errors[] = 'Please select Holdable as Yes or No.';
}
if (!valid_yes_no($ecl_circulate)) {
    $errors[] = 'Please select Circulate as Yes or No.';
}

if (!$errors) {
    $lines = [
        'Ticket Type: Request New Copy Location',
        "Requester Email: {$requester_email}",
        "Library: {$requester_library}",
        "Location Name: {$ecl_location_name}",
        "OPAC Visible: {$ecl_opac_visible}",
        "Holdable: {$ecl_holdable}",
        "Circulate: {$ecl_circulate}",
        'Additional Comments: ' . ($ecl_additional_comments !== '' ? $ecl_additional_comments : 'None'),
    ];

    $subject = 'OWWL Help - Request New Copy Location';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    $message = implode("\n", $lines);

    $mail_sent = @mail($evergreen_email, $subject, $message, $headers);

    if ($mail_sent) {
        $success_message = 'Your request has been sent.';
        $requester_library = '';
        $ecl_location_name = '';
        $ecl_opac_visible = '';
        $ecl_holdable = '';
        $ecl_circulate = '';
        $ecl_additional_comments = '';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
