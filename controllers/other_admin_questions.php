<?php

$admin_question = post_value('admin_question', $admin_question);

if ($admin_question === '') {
    $errors[] = 'Please enter the question.';
}

if (!$errors) {
    $subject = 'OWWL Help - Other admin questions';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    try {
        $message = render_email_template('other_admin_questions', [
            'requester_email' => $requester_email,
            'requester_library' => $requester_library,
            'admin_question' => $admin_question,
        ]);
    } catch (RuntimeException $e) {
        $errors[] = 'Email template configuration error. Please contact support.';
    }

    $mail_sent = !$errors ? @mail($admin_email, $subject, $message, $headers) : false;

    if ($mail_sent) {
        $success_message = 'Your request has been sent.';
        $requester_library = '';
        $admin_question = '';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
