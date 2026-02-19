<?php

$new_user_name = post_value('new_user_name', $new_user_name);
$new_start_date = post_value('new_start_date', $new_start_date);
$new_email_groups = post_array('new_email_groups');
$new_evergreen_required = post_value('new_evergreen_required', $new_evergreen_required);
$new_evergreen_type = post_value('new_evergreen_type', $new_evergreen_type);
$new_cataloging_addon = post_value('new_cataloging_addon', $new_cataloging_addon);
$new_ad_required = post_value('new_ad_required', $new_ad_required);

if ($new_user_name === '') {
    $errors[] = 'Please enter the user first and last name.';
}
if ($new_start_date === '') {
    $errors[] = 'Please select a start date.';
}
if (!valid_yes_no($new_evergreen_required)) {
    $errors[] = 'Please indicate whether an Evergreen account is required.';
}
if ($new_evergreen_required === 'Yes') {
    if ($new_evergreen_type === '') {
        $errors[] = 'Please select an Evergreen account type.';
    } elseif (!in_array($new_evergreen_type, $evergreen_account_types, true)) {
        $errors[] = 'Please select a valid Evergreen account type.';
    }
    if (!valid_yes_no($new_cataloging_addon)) {
        $new_cataloging_addon = 'No';
    }
}
if (!valid_yes_no($new_ad_required)) {
    $errors[] = 'Please indicate whether an Active Directory account is needed.';
}

if (!$errors) {
    $valid_groups = selected_from_allowed($new_email_groups, $listservs);
    $groups_display = $valid_groups ? implode(', ', $valid_groups) : 'None';

    $requester_lines = [
        'Ticket Type: New User Account',
        "Requester Email: {$requester_email}",
        "Library: {$requester_library}",
    ];
    if ($requester_notes !== '') {
        $requester_lines[] = "Requester Notes: {$requester_notes}";
    }

    $email_account_lines = [
        "User Name: {$new_user_name}",
        "Start Date: {$new_start_date}",
        "Email Groups/Listservs: {$groups_display}",
    ];

    $ad_lines = [
        "Active Directory Account Needed: {$new_ad_required}",
    ];

    $evergreen_lines = [
        "Evergreen Account Required: {$new_evergreen_required}",
    ];
    if ($new_evergreen_required === 'Yes') {
        $evergreen_lines[] = "Evergreen Account Type: {$new_evergreen_type}";
        $evergreen_lines[] = "Item Cataloging Add-on Needed: {$new_cataloging_addon}";
    }

    $subject = 'OWWL Help - New User Account Request';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    $primary_message = implode("\n", array_merge($requester_lines, $email_account_lines, $ad_lines));
    $evergreen_message = implode("\n", array_merge($requester_lines, $email_account_lines, $evergreen_lines));

    $primary_sent = @mail($primary_email, $subject, $primary_message, $headers);
    $evergreen_sent = true;
    if ($new_evergreen_required === 'Yes') {
        $evergreen_sent = @mail($evergreen_email, $subject, $evergreen_message, $headers);
    }

    if ($primary_sent && $evergreen_sent) {
        $success_message = 'Your request has been sent.';
        $requester_email = '';
        $requester_library = '';
        $requester_notes = '';
        $new_user_name = '';
        $new_start_date = '';
        $new_email_groups = [];
        $new_evergreen_required = 'No';
        $new_evergreen_type = '';
        $new_cataloging_addon = 'No';
        $new_ad_required = 'No';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
