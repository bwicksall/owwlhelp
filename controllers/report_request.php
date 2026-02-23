<?php

$er_select_report = post_value('er_select_report', $er_select_report);
$er_custom_report_description = post_value('er_custom_report_description', $er_custom_report_description);
$er_other_comments = post_value('er_other_comments', $er_other_comments);
$er_deadline = post_value('er_deadline', $er_deadline);

$allowed_reports = ['Need Custom Report', 'Detailed Cash Report', 'Magazine Annual Circ'];

if ($er_select_report === '' || !in_array($er_select_report, $allowed_reports, true)) {
    $errors[] = 'Please select a valid report.';
}

if (!$errors) {
    $lines = [
        'Ticket Type: Request a Report',
        "Requester Email: {$requester_email}",
        "Library: {$requester_library}",
        "Select Report: {$er_select_report}",
        'Custom Report Detailed Description: ' . ($er_custom_report_description !== '' ? $er_custom_report_description : 'None'),
        'Other Comments: ' . ($er_other_comments !== '' ? $er_other_comments : 'None'),
        'Deadline: ' . ($er_deadline !== '' ? $er_deadline : 'None'),
    ];

    $subject = 'OWWL Help - Request a Report';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    $message = implode("\n", $lines);

    $mail_sent = @mail($reports_email, $subject, $message, $headers);

    if ($mail_sent) {
        $success_message = 'Your request has been sent.';
        $requester_library = '';
        $er_select_report = '';
        $er_custom_report_description = '';
        $er_other_comments = '';
        $er_deadline = '';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
