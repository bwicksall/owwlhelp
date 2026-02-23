<?php
session_start();

require __DIR__ . '/config.php';
require __DIR__ . '/includes/app.php';

$errors = [];
$success_message = '';
$auth_message = '';
$auth_message_type = '';

$view = $_GET['form'] ?? 'landing';
$allowed_views = ['landing', 'new', 'modify', 'delete', 'overdrive', 'reference', 'cba', 'catalog_issue', 'original_cataloging', 'evergreen_issue', 'new_copy_location', 'report_request', 'general_support'];
if (!in_array($view, $allowed_views, true)) {
    $view = 'landing';
}

// Shared requester defaults.
$requester_email = requester_get_active_email();
$requester_library = '';
$requester_notes = '';

// New account defaults.
$new_user_name = '';
$new_start_date = '';
$new_email_groups = [];
$new_evergreen_required = 'No';
$new_evergreen_type = '';
$new_cataloging_addon = 'No';
$new_ad_required = 'No';

// Modify account defaults.
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

// Delete account defaults.
$del_user_id = '';
$del_full_name = '';
$del_last_day = '';
$del_forward_email = 'No';
$del_forward_target = '';

// Overdrive merge defaults.
$od_patron_last_name = '';
$od_new_card_number = '';

// Reference question defaults.
$ref_request_type = '';
$ref_subject_topic = '';
$ref_sources_consulted = '';
$ref_notes_comments = '';

// CBA purchase defaults.
$cba_author = '';
$cba_title = '';
$cba_publisher = '';
$cba_year = '';
$cba_isbn = '';
$cba_subject_topic = '';
$cba_citation_source = '';
$cba_notes_comments = '';
$cba_format = '';

// Catalog issue defaults.
$cat_problem = '';
$cat_material_type = '';
$cat_format = '';
$cat_description = '';
$cat_author = '';
$cat_title = '';
$cat_publisher = '';
$cat_year = '';
$cat_isbn_ups = '';
$cat_additional_comments = '';

// Original cataloging defaults.
$oc_title_subtitle = '';
$oc_material_type = '';
$oc_genre_category = '';
$oc_physical_description = '';
$oc_summary = '';
$oc_format = '';
$oc_additional_format_info = '';
$oc_author = '';
$oc_publisher_manufacturer = '';
$oc_year_details = '';
$oc_need_by_date = '';
$oc_additional_material_details = '';
$oc_additional_comments = '';
$oc_isbn_upc = '';

// Evergreen defaults.
$eg_problem_type = '';
$eg_issue = '';
$ecl_location_name = '';
$ecl_opac_visible = '';
$ecl_holdable = '';
$ecl_circulate = '';
$ecl_additional_comments = '';
$er_select_report = '';
$er_custom_report_description = '';
$er_other_comments = '';
$er_deadline = '';

// Tech support defaults.
$ts_subject = '';
$ts_description = '';

$requester_verified = $requester_email !== '' && requester_is_verified($requester_email);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth_action = post_value('auth_action');
    $form_type = post_value('form_type');
    $view = $form_type === 'new' || $form_type === 'modify' || $form_type === 'delete' || $form_type === 'overdrive' || $form_type === 'reference' || $form_type === 'cba' || $form_type === 'catalog_issue' || $form_type === 'original_cataloging' || $form_type === 'evergreen_issue' || $form_type === 'new_copy_location' || $form_type === 'report_request' || $form_type === 'general_support' ? $form_type : 'landing';

    $requester_email = post_value('requester_email');
    $requester_library = post_value('requester_library');
    $requester_notes = post_value('requester_notes');
    $requester_verified = $requester_email !== '' && requester_is_verified($requester_email);

    if ($auth_action === 'send_otp') {
        if ($requester_email === '' || !filter_var($requester_email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid requester email address before requesting an OTP.';
        } elseif (!email_domain_allowed($requester_email, $allowed_email_domains)) {
            $errors[] = 'This email domain is not allowed for authentication.';
        } else {
            // Starting a new challenge requires a fresh OTP verification.
            requester_clear_verified($requester_email);
            $requester_verified = false;
            requester_set_active_email($requester_email);
            $otp_code = otp_generate_code();
            otp_store_challenge($requester_email, $otp_code, $otp_ttl_seconds);
            $mail_subject = 'OWWL Help OTP Code';
            $mail_message = "Your OWWL Help verification code is: {$otp_code}\n\nThis code expires in " . (int) round($otp_ttl_seconds / 60) . " minutes.";
            $mail_headers = "From: {$primary_email}\r\nReply-To: {$primary_email}\r\n";
            $otp_sent = @mail($requester_email, $mail_subject, $mail_message, $mail_headers);
            if ($otp_sent) {
                $auth_message = 'An OTP code has been sent to your email address.';
                $auth_message_type = 'success';
            } else {
                $errors[] = 'Unable to send OTP email. Please try again or contact support.';
            }
        }
    } elseif ($auth_action === 'verify_otp') {
        $otp_code = post_value('otp_code');
        if ($requester_email === '' || !filter_var($requester_email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid requester email address before verifying an OTP.';
        } elseif (!email_domain_allowed($requester_email, $allowed_email_domains)) {
            $errors[] = 'This email domain is not allowed for authentication.';
        } elseif ($otp_code === '') {
            $errors[] = 'Please enter the OTP code.';
        } elseif (!otp_verify_challenge($requester_email, $otp_code)) {
            $errors[] = 'The OTP code is invalid or expired.';
        } else {
            requester_mark_verified($requester_email);
            otp_clear_challenge($requester_email);
            requester_set_active_email($requester_email);
            $requester_verified = true;
            $auth_message = 'Email verification successful. The form is now unlocked for this session.';
            $auth_message_type = 'success';
        }
    } else {
        if ($requester_email === '' || !filter_var($requester_email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid requester email address.';
        } elseif (!email_domain_allowed($requester_email, $allowed_email_domains)) {
            $errors[] = 'This email domain is not allowed for authentication.';
        } elseif (!requester_is_verified($requester_email)) {
            $errors[] = 'Please complete OTP verification for the requester email before submitting.';
        } else {
            $requester_verified = true;
            requester_set_active_email($requester_email);
        }

        if ($requester_verified) {
            if ($requester_library === '') {
                $errors[] = 'Please select a library.';
            } elseif (!in_array($requester_library, $libraries, true)) {
                $errors[] = 'Please select a valid library.';
            }
        }

        if ($view === 'new' && $requester_verified) {
            require __DIR__ . '/controllers/new_account.php';
        } elseif ($view === 'modify' && $requester_verified) {
            require __DIR__ . '/controllers/modify_account.php';
        } elseif ($view === 'delete' && $requester_verified) {
            require __DIR__ . '/controllers/delete_account.php';
        } elseif ($view === 'overdrive' && $requester_verified) {
            require __DIR__ . '/controllers/overdrive_merge.php';
        } elseif ($view === 'reference' && $requester_verified) {
            require __DIR__ . '/controllers/reference_question.php';
        } elseif ($view === 'cba' && $requester_verified) {
            require __DIR__ . '/controllers/cba_purchase.php';
        } elseif ($view === 'catalog_issue' && $requester_verified) {
            require __DIR__ . '/controllers/catalog_issue.php';
        } elseif ($view === 'original_cataloging' && $requester_verified) {
            require __DIR__ . '/controllers/original_cataloging.php';
        } elseif ($view === 'evergreen_issue' && $requester_verified) {
            require __DIR__ . '/controllers/evergreen_issue.php';
        } elseif ($view === 'new_copy_location' && $requester_verified) {
            require __DIR__ . '/controllers/new_copy_location.php';
        } elseif ($view === 'report_request' && $requester_verified) {
            require __DIR__ . '/controllers/report_request.php';
        } elseif ($view === 'general_support' && $requester_verified) {
            require __DIR__ . '/controllers/general_support.php';
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OWWL Help</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600&family=Source+Serif+4:wght@400;600&display=swap">
    <link rel="stylesheet" href="assets/css/styles.css">
  </head>
  <body>
    <main class="page-shell">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
        <div>
          <h1 class="h2 mb-2">OWWL Help</h1>
          <p class="mb-0 text-muted">Ticketing front end</p>
        </div>
        <?php if ($view !== 'landing'): ?>
          <a class="btn btn-outline-secondary btn-sm" href="index.php">Back to Form Selection</a>
        <?php endif; ?>
      </div>

      <?php if ($errors): ?>
        <div class="alert alert-danger">
          <strong>There were problems with your submission:</strong>
          <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
              <li><?= h($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <?php if ($success_message): ?>
        <div class="alert alert-success"><?= h($success_message) ?></div>
      <?php endif; ?>
      <?php if ($auth_message): ?>
        <div class="alert alert-<?= h($auth_message_type ?: 'info') ?>"><?= h($auth_message) ?></div>
      <?php endif; ?>

      <?php
      if ($view === 'new') {
          require __DIR__ . '/views/new_form.php';
      } elseif ($view === 'modify') {
          require __DIR__ . '/views/modify_form.php';
      } elseif ($view === 'delete') {
          require __DIR__ . '/views/delete_form.php';
      } elseif ($view === 'overdrive') {
          require __DIR__ . '/views/overdrive_form.php';
      } elseif ($view === 'reference') {
          require __DIR__ . '/views/reference_form.php';
      } elseif ($view === 'cba') {
          require __DIR__ . '/views/cba_form.php';
      } elseif ($view === 'catalog_issue') {
          require __DIR__ . '/views/catalog_issue_form.php';
      } elseif ($view === 'original_cataloging') {
          require __DIR__ . '/views/original_cataloging_form.php';
      } elseif ($view === 'evergreen_issue') {
          require __DIR__ . '/views/evergreen_issue_form.php';
      } elseif ($view === 'new_copy_location') {
          require __DIR__ . '/views/new_copy_location_form.php';
      } elseif ($view === 'report_request') {
          require __DIR__ . '/views/report_request_form.php';
      } elseif ($view === 'general_support') {
          require __DIR__ . '/views/general_support_form.php';
      } else {
          require __DIR__ . '/views/landing.php';
      }
      ?>
    </main>

    <script src="assets/js/form.js"></script>
  </body>
</html>
