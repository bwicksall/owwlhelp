<?php

$delivery_question = post_value('delivery_question', $delivery_question);

if ($delivery_question === '') {
    $errors[] = 'Please enter the question.';
}

if (!$errors) {
    $subject = 'OWWL Help - Delivery Questions';
    $headers = "From: {$requester_email}\r\nReply-To: {$requester_email}\r\n";
    try {
        $message = render_email_template('delivery_questions', [
            'requester_email' => $requester_email,
            'requester_library' => $requester_library,
            'delivery_question' => $delivery_question,
        ]);
    } catch (RuntimeException $e) {
        $errors[] = 'Email template configuration error. Please contact support.';
    }

    $mail_sent = !$errors ? @mail($delivery_email, $subject, $message, $headers) : false;

    if ($mail_sent) {
        $success_message = 'Your request has been sent.';
        $requester_library = '';
        $delivery_question = '';
    } else {
        $errors[] = 'Your request could not be sent. Please try again or contact support.';
    }
}
