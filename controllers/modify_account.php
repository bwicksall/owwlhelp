<?php

$mod_change_email = post_value('mod_change_email', $mod_change_email);
$mod_email_address = post_value('mod_email_address', $mod_email_address);
$mod_email_groups = post_array('mod_email_groups');
$mod_email_notes = post_value('mod_email_notes', $mod_email_notes);
$mod_change_evergreen = post_value('mod_change_evergreen', $mod_change_evergreen);
$mod_evergreen_user_id = post_value('mod_evergreen_user_id', $mod_evergreen_user_id);
$mod_evergreen_type = post_value('mod_evergreen_type', $mod_evergreen_type);
$mod_cataloging_addon = post_value('mod_cataloging_addon', $mod_cataloging_addon);
$mod_evergreen_notes = post_value('mod_evergreen_notes', $mod_evergreen_notes);
$mod_change_ad = post_value('mod_change_ad', $mod_change_ad);
$mod_ad_user_id = post_value('mod_ad_user_id', $mod_ad_user_id);
$mod_ad_notes = post_value('mod_ad_notes', $mod_ad_notes);

if (!valid_yes_no($mod_change_email)) {
    $errors[] = 'Please indicate whether the email account should be changed.';
}
if ($mod_change_email === 'Yes') {
    if ($mod_email_address === '' || !filter_var($mod_email_address, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email account address.';
    }
}

if (!valid_yes_no($mod_change_evergreen)) {
    $errors[] = 'Please indicate whether the Evergreen account should be changed.';
}
if ($mod_change_evergreen === 'Yes') {
    if ($mod_evergreen_user_id === '') {
        $errors[] = 'Please enter the Evergreen user ID.';
    }
    if ($mod_evergreen_type !== '' && !in_array($mod_evergreen_type, $evergreen_account_types, true)) {
        $errors[] = 'Please select a valid Evergreen account type.';
    }
    if (!valid_yes_no($mod_cataloging_addon)) {
        $mod_cataloging_addon = 'No';
    }
}

if (!valid_yes_no($mod_change_ad)) {
    $errors[] = 'Please indicate whether the Active Directory account should be changed.';
}
if ($mod_change_ad === 'Yes' && $mod_ad_user_id === '') {
    $errors[] = 'Please enter the Active Directory user ID.';
}

if (!$errors) {
    $valid_groups = selected_from_allowed($mod_email_groups, $listservs);
    $groups_display = $valid_groups ? implode(', ', $valid_groups) : 'None';

    $requester_lines = [
        'Ticket Type: Modify Existing Account',
        "Requester Email: {$requester_email}",
        "Library: {$requester_library}",
    ];
    if ($requester_notes !== '') {
        $requester_lines[] = "Requester Notes: {$requester_notes}";
    }

    $email_account_lines = [
        "Change Email Account: {$mod_change_email}",
    ];
    if ($mod_change_email === 'Yes') {
        $email_account_lines[] = "Email Address: {$mod_email_address}";
        $email_account_lines[] = "Email Groups/Listservs: {$groups_display}";
        $email_account_lines[] = 'Email Account Notes: ' . ($mod_email_notes !== '' ? $mod_email_notes : 'None');
    }

    $ad_lines = [
        "Change Active Directory Account: {$mod_change_ad}",
    ];
    if ($mod_change_ad === 'Yes') {
        $ad_lines[] = "Active Directory User ID: {$mod_ad_user_id}";
        $ad_lines[] = 'Please Describe the Change: ' . ($mod_ad_notes !== '' ? $mod_ad_notes : 'None');
    }

    $evergreen_lines = [
        "Change Evergreen Account: {$mod_change_evergreen}",
    ];
    if ($mod_change_evergreen === 'Yes') {
        $evergreen_lines[] = "Evergreen User ID: {$mod_evergreen_user_id}";
        $evergreen_lines[] = 'Evergreen Account Type: ' . ($mod_evergreen_type !== '' ? $mod_evergreen_type : 'None');
        $evergreen_lines[] = "Item Cataloging Add-on Needed: {$mod_cataloging_addon}";
        $evergreen_lines[] = 'Evergreen Notes: ' . ($mod_evergreen_notes !== '' ? $mod_evergreen_notes : 'None');
    }

    $subject = 'OWWL Help - Modify Existing Account Request';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    $primary_message = implode("\n", array_merge($requester_lines, $email_account_lines, $ad_lines));
    $evergreen_message = implode("\n", array_merge($requester_lines, $email_account_lines, $evergreen_lines));

    $primary_sent = @mail($primary_email, $subject, $primary_message, $headers);
    $evergreen_sent = true;
    if ($mod_change_evergreen === 'Yes') {
        $evergreen_sent = @mail($evergreen_email, $subject, $evergreen_message, $headers);
    }

    if ($primary_sent && $evergreen_sent) {
        $success_message = 'Your request has been sent.';
        $requester_library = '';
        $requester_notes = '';
        $mod_change_email = 'No';
        $mod_email_address = '';
        $mod_email_groups = [];
        $mod_email_notes = '';
        $mod_change_evergreen = 'No';
        $mod_evergreen_user_id = '';
        $mod_evergreen_type = '';
        $mod_cataloging_addon = 'No';
        $mod_evergreen_notes = '';
        $mod_change_ad = 'No';
        $mod_ad_user_id = '';
        $mod_ad_notes = '';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
