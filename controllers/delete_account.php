<?php

$del_user_id = post_value('del_user_id', $del_user_id);
$del_full_name = post_value('del_full_name', $del_full_name);
$del_last_day = post_value('del_last_day', $del_last_day);
$del_forward_email = post_value('del_forward_email', $del_forward_email);
$del_forward_target = post_value('del_forward_target', $del_forward_target);

if ($del_user_id === '') {
    $errors[] = 'Please enter the user ID.';
}
if ($del_last_day === '') {
    $errors[] = 'Please select the user\'s last day.';
}
if (!valid_yes_no($del_forward_email)) {
    $errors[] = 'Please indicate whether email forwarding is required.';
}
if ($del_forward_email === 'Yes') {
    if ($del_forward_target === '' || !filter_var($del_forward_target, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid target email address for forwarding.';
    }
}

if (!$errors) {
    $requester_lines = [
        'Ticket Type: Delete Account',
        "Requester Email: {$requester_email}",
        "Library: {$requester_library}",
    ];
    if ($requester_notes !== '') {
        $requester_lines[] = "Requester Notes: {$requester_notes}";
    }

    $delete_lines = [
        "User ID: {$del_user_id}",
        'Full Name: ' . ($del_full_name !== '' ? $del_full_name : 'None'),
        "User Last Day: {$del_last_day}",
        "Forward Email for 60 Days: {$del_forward_email}",
    ];
    if ($del_forward_email === 'Yes') {
        $delete_lines[] = "Forwarding Target Email: {$del_forward_target}";
    }

    $subject = 'OWWL Help - Delete Account Request';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    $message = implode("\n", array_merge($requester_lines, $delete_lines));

    $primary_sent = @mail($primary_email, $subject, $message, $headers);
    $evergreen_sent = @mail($evergreen_email, $subject, $message, $headers);

    if ($primary_sent && $evergreen_sent) {
        $success_message = 'Your request has been sent.';
        $requester_email = '';
        $requester_library = '';
        $requester_notes = '';
        $del_user_id = '';
        $del_full_name = '';
        $del_last_day = '';
        $del_forward_email = 'No';
        $del_forward_target = '';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
