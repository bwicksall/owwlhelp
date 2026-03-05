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
    $subject = 'OWWL Help - Request a Report';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    try {
        $message = render_email_template('report_request', [
            'requester_email' => $requester_email,
            'requester_library' => $requester_library,
            'er_select_report' => $er_select_report,
            'er_custom_report_description' => optional_value($er_custom_report_description),
            'er_other_comments' => optional_value($er_other_comments),
            'er_deadline' => optional_value($er_deadline),
        ]);
    } catch (RuntimeException $e) {
        $errors[] = 'Email template configuration error. Please contact support.';
    }

    $mail_sent = !$errors ? @mail($reports_email, $subject, $message, $headers) : false;

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
