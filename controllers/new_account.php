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
    $primary_account_details = "Active Directory Account Needed: {$new_ad_required}";
    $evergreen_account_details = "Evergreen Account Required: {$new_evergreen_required}";
    if ($new_evergreen_required === 'Yes') {
        $evergreen_account_details .= "\nEvergreen Account Type: {$new_evergreen_type}";
        $evergreen_account_details .= "\nItem Cataloging Add-on Needed: {$new_cataloging_addon}";
    }

    $subject = 'OWWL Help - New User Account Request';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    try {
        $primary_message = render_email_template('new_account', [
            'requester_email' => $requester_email,
            'requester_library' => $requester_library,
            'requester_notes' => optional_value($requester_notes),
            'new_user_name' => $new_user_name,
            'new_start_date' => $new_start_date,
            'email_groups' => $groups_display,
            'account_details' => $primary_account_details,
        ]);
        $evergreen_message = render_email_template('new_account', [
            'requester_email' => $requester_email,
            'requester_library' => $requester_library,
            'requester_notes' => optional_value($requester_notes),
            'new_user_name' => $new_user_name,
            'new_start_date' => $new_start_date,
            'email_groups' => $groups_display,
            'account_details' => $evergreen_account_details,
        ]);
    } catch (RuntimeException $e) {
        $errors[] = 'Email template configuration error. Please contact support.';
    }

    $primary_sent = false;
    $evergreen_sent = true;
    if (!$errors) {
        $primary_sent = @mail($primary_email, $subject, $primary_message, $headers);
        if ($new_evergreen_required === 'Yes') {
            $evergreen_sent = @mail($evergreen_email, $subject, $evergreen_message, $headers);
        }
    }

    if ($primary_sent && $evergreen_sent) {
        $success_message = 'Your request has been sent.';
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
