<?php
require __DIR__ . '/config.php';
require __DIR__ . '/includes/app.php';

$errors = [];
$success_message = '';

$view = $_GET['form'] ?? 'landing';
$allowed_views = ['landing', 'new', 'modify', 'delete'];
if (!in_array($view, $allowed_views, true)) {
    $view = 'landing';
}

// Shared requester defaults.
$requester_email = '';
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = post_value('form_type');
    $view = $form_type === 'new' || $form_type === 'modify' || $form_type === 'delete' ? $form_type : 'landing';

    $requester_email = post_value('requester_email');
    $requester_library = post_value('requester_library');
    $requester_notes = post_value('requester_notes');

    if ($requester_email === '' || !filter_var($requester_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid requester email address.';
    }
    if ($requester_library === '') {
        $errors[] = 'Please select a library.';
    } elseif (!in_array($requester_library, $libraries, true)) {
        $errors[] = 'Please select a valid library.';
    }

    if ($view === 'new') {
        require __DIR__ . '/controllers/new_account.php';
    } elseif ($view === 'modify') {
        require __DIR__ . '/controllers/modify_account.php';
    } elseif ($view === 'delete') {
        require __DIR__ . '/controllers/delete_account.php';
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

      <?php
      if ($view === 'new') {
          require __DIR__ . '/views/new_form.php';
      } elseif ($view === 'modify') {
          require __DIR__ . '/views/modify_form.php';
      } elseif ($view === 'delete') {
          require __DIR__ . '/views/delete_form.php';
      } else {
          require __DIR__ . '/views/landing.php';
      }
      ?>
    </main>

    <script src="assets/js/form.js"></script>
  </body>
</html>
