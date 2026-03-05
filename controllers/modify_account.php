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
    $email_address_value = $mod_change_email === 'Yes' ? $mod_email_address : 'None';
    $email_groups_value = $mod_change_email === 'Yes' ? $groups_display : 'None';
    $email_notes_value = $mod_change_email === 'Yes' ? optional_value($mod_email_notes) : 'None';

    $primary_account_details = "Change Active Directory Account: {$mod_change_ad}";
    if ($mod_change_ad === 'Yes') {
        $primary_account_details .= "\nActive Directory User ID: {$mod_ad_user_id}";
        $primary_account_details .= "\nPlease Describe the Change: " . optional_value($mod_ad_notes);
    }

    $evergreen_account_details = "Change Evergreen Account: {$mod_change_evergreen}";
    if ($mod_change_evergreen === 'Yes') {
        $evergreen_account_details .= "\nEvergreen User ID: {$mod_evergreen_user_id}";
        $evergreen_account_details .= "\nEvergreen Account Type: " . optional_value($mod_evergreen_type);
        $evergreen_account_details .= "\nItem Cataloging Add-on Needed: {$mod_cataloging_addon}";
        $evergreen_account_details .= "\nEvergreen Notes: " . optional_value($mod_evergreen_notes);
    }

    $subject = 'OWWL Help - Modify Existing Account Request';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    try {
        $primary_message = render_email_template('modify_account', [
            'requester_email' => $requester_email,
            'requester_library' => $requester_library,
            'requester_notes' => optional_value($requester_notes),
            'mod_change_email' => $mod_change_email,
            'mod_email_address' => $email_address_value,
            'mod_email_groups' => $email_groups_value,
            'mod_email_notes' => $email_notes_value,
            'account_details' => $primary_account_details,
        ]);
        $evergreen_message = render_email_template('modify_account', [
            'requester_email' => $requester_email,
            'requester_library' => $requester_library,
            'requester_notes' => optional_value($requester_notes),
            'mod_change_email' => $mod_change_email,
            'mod_email_address' => $email_address_value,
            'mod_email_groups' => $email_groups_value,
            'mod_email_notes' => $email_notes_value,
            'account_details' => $evergreen_account_details,
        ]);
    } catch (RuntimeException $e) {
        $errors[] = 'Email template configuration error. Please contact support.';
    }

    $primary_sent = false;
    $evergreen_sent = true;
    if (!$errors) {
        $primary_sent = @mail($primary_email, $subject, $primary_message, $headers);
        if ($mod_change_evergreen === 'Yes') {
            $evergreen_sent = @mail($evergreen_email, $subject, $evergreen_message, $headers);
        }
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
