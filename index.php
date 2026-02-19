<?php
require __DIR__ . '/config.php';

$destination_email = $config['destination_email'] ?? 'bwicksall@owwl.org';
$primary_email = $config['primary_email'] ?? $destination_email;
$evergreen_email = $config['evergreen_email'] ?? 'webmaster@owwl.org';
$libraries = $config['libraries'] ?? ['Test Library 1', 'Test Library 2'];
$listservs = $config['listservs'] ?? ['YSL-L', 'Holdings'];
$evergreen_account_types = $config['evergreen_account_types'] ?? ['Basic (No Circ)', 'Circ I', 'Circ II'];

$errors = [];
$success_message = '';

function h(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function post_value(string $key, string $default = ''): string {
    if (!isset($_POST[$key])) {
        return $default;
    }
    return trim((string) $_POST[$key]);
}

function post_array(string $key): array {
    if (!isset($_POST[$key]) || !is_array($_POST[$key])) {
        return [];
    }
    return array_values($_POST[$key]);
}

function valid_yes_no(string $value): bool {
    return $value === 'Yes' || $value === 'No';
}

function selected_from_allowed(array $selected, array $allowed): array {
    return array_values(array_intersect($allowed, $selected));
}

$view = $_GET['form'] ?? 'landing';
$allowed_views = ['landing', 'new', 'modify'];
if (!in_array($view, $allowed_views, true)) {
    $view = 'landing';
}

// Shared requester values.
$requester_email = '';
$requester_library = '';
$requester_notes = '';

// New account defaults and values.
$new_user_name = '';
$new_start_date = '';
$new_email_groups = [];
$new_evergreen_required = 'No';
$new_evergreen_type = '';
$new_cataloging_addon = 'No';
$new_ad_required = 'No';

// Modify account defaults and values.
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = post_value('form_type');
    $view = $form_type === 'new' || $form_type === 'modify' ? $form_type : 'landing';

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
        $new_user_name = post_value('new_user_name');
        $new_start_date = post_value('new_start_date');
        $new_email_groups = post_array('new_email_groups');
        $new_evergreen_required = post_value('new_evergreen_required', 'No');
        $new_evergreen_type = post_value('new_evergreen_type');
        $new_cataloging_addon = post_value('new_cataloging_addon', 'No');
        $new_ad_required = post_value('new_ad_required', 'No');

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
    } elseif ($view === 'modify') {
        $mod_change_email = post_value('mod_change_email', 'No');
        $mod_email_address = post_value('mod_email_address');
        $mod_email_groups = post_array('mod_email_groups');
        $mod_email_notes = post_value('mod_email_notes');
        $mod_change_evergreen = post_value('mod_change_evergreen', 'No');
        $mod_evergreen_user_id = post_value('mod_evergreen_user_id');
        $mod_evergreen_type = post_value('mod_evergreen_type');
        $mod_cataloging_addon = post_value('mod_cataloging_addon', 'No');
        $mod_evergreen_notes = post_value('mod_evergreen_notes');
        $mod_change_ad = post_value('mod_change_ad', 'No');
        $mod_ad_user_id = post_value('mod_ad_user_id');
        $mod_ad_notes = post_value('mod_ad_notes');

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
            if ($mod_evergreen_type === '') {
                $errors[] = 'Please select an Evergreen account type.';
            } elseif (!in_array($mod_evergreen_type, $evergreen_account_types, true)) {
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
                $evergreen_lines[] = "Evergreen Account Type: {$mod_evergreen_type}";
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
                $requester_email = '';
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

      <?php if ($view === 'landing'): ?>
        <section class="form-selection">
          <h2 class="h4 mb-3">Select a request type</h2>
          <div class="row g-3">
            <div class="col-md-6">
              <a class="selection-card" href="index.php?form=new">
                <span class="selection-title">Request a new user account</span>
                <span class="selection-desc">Create an email account and optional Evergreen/AD access.</span>
              </a>
            </div>
            <div class="col-md-6">
              <a class="selection-card" href="index.php?form=modify">
                <span class="selection-title">Modify a user account</span>
                <span class="selection-desc">Request targeted changes to existing email, Evergreen, or AD account details.</span>
              </a>
            </div>
          </div>
        </section>
      <?php endif; ?>

      <?php if ($view === 'new'): ?>
        <h2 class="h4 mb-3">New user account request</h2>
        <form method="post" novalidate>
          <input type="hidden" name="form_type" value="new">

          <div class="section-card mb-4">
            <div class="section-title mb-3">Requester</div>
            <div class="row g-3">
              <div class="col-md-6">
                <label for="requester_email" class="form-label">Requester Email</label>
                <input type="email" class="form-control" id="requester_email" name="requester_email" value="<?= h($requester_email) ?>" required>
                <div class="form-text">This is used as the sender address.</div>
              </div>
              <div class="col-md-6">
                <label for="requester_library" class="form-label">Library</label>
                <select class="form-select" id="requester_library" name="requester_library" required>
                  <option value="" <?= $requester_library === '' ? 'selected' : '' ?>>Select a library</option>
                  <?php foreach ($libraries as $library): ?>
                    <option value="<?= h($library) ?>" <?= $requester_library === $library ? 'selected' : '' ?>><?= h($library) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-12">
                <label for="requester_notes" class="form-label">Notes (optional)</label>
                <textarea class="form-control" id="requester_notes" name="requester_notes" rows="3"><?= h($requester_notes) ?></textarea>
              </div>
            </div>
          </div>

          <div class="section-card mb-4">
            <div class="section-title mb-3">Email Account</div>
            <div class="row g-3">
              <div class="col-md-6">
                <label for="new_user_name" class="form-label">User First and Last Name</label>
                <input type="text" class="form-control" id="new_user_name" name="new_user_name" value="<?= h($new_user_name) ?>" required>
              </div>
              <div class="col-md-6">
                <label for="new_start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="new_start_date" name="new_start_date" value="<?= h($new_start_date) ?>" required>
              </div>
              <div class="col-12">
                <label class="form-label">Email Groups/Listservs (optional)</label>
                <div class="d-flex flex-wrap gap-3">
                  <?php foreach ($listservs as $listserv): ?>
                    <?php $listserv_id = 'new_listserv_' . preg_replace('/[^a-z0-9]+/i', '_', strtolower($listserv)); ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="new_email_groups[]" id="<?= h($listserv_id) ?>" value="<?= h($listserv) ?>" <?= in_array($listserv, $new_email_groups, true) ? 'checked' : '' ?>>
                      <label class="form-check-label" for="<?= h($listserv_id) ?>"><?= h($listserv) ?></label>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>

          <div class="section-card mb-4">
            <div class="section-title mb-3">Evergreen Account</div>
            <div class="row g-3 align-items-end">
              <div class="col-md-4">
                <label class="form-label">Evergreen Required?</label>
                <div class="d-flex gap-3">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="new_evergreen_required" id="new_evergreen_yes" value="Yes" <?= $new_evergreen_required === 'Yes' ? 'checked' : '' ?> required>
                    <label class="form-check-label" for="new_evergreen_yes">Yes</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="new_evergreen_required" id="new_evergreen_no" value="No" <?= $new_evergreen_required === 'No' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="new_evergreen_no">No</label>
                  </div>
                </div>
              </div>
              <div class="col-md-4 new-evergreen-fields">
                <label for="new_evergreen_type" class="form-label">Account Type</label>
                <select class="form-select" id="new_evergreen_type" name="new_evergreen_type">
                  <option value="" <?= $new_evergreen_type === '' ? 'selected' : '' ?>>Select type</option>
                  <?php foreach ($evergreen_account_types as $account_type): ?>
                    <option value="<?= h($account_type) ?>" <?= $new_evergreen_type === $account_type ? 'selected' : '' ?>><?= h($account_type) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4 new-evergreen-fields">
                <label class="form-label">Item Cataloging Add-on</label>
                <div class="d-flex gap-3">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="new_cataloging_addon" id="new_cataloging_yes" value="Yes" <?= $new_cataloging_addon === 'Yes' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="new_cataloging_yes">Yes</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="new_cataloging_addon" id="new_cataloging_no" value="No" <?= $new_cataloging_addon === 'No' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="new_cataloging_no">No</label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="section-card mb-4">
            <div class="section-title mb-2">Active Directory</div>
            <p class="form-text mb-3">Active Directory is required if the user needs to login to a library staff computer with a personal account.</p>
            <div class="d-flex gap-3">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="new_ad_required" id="new_ad_yes" value="Yes" <?= $new_ad_required === 'Yes' ? 'checked' : '' ?> required>
                <label class="form-check-label" for="new_ad_yes">Yes</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="new_ad_required" id="new_ad_no" value="No" <?= $new_ad_required === 'No' ? 'checked' : '' ?>>
                <label class="form-check-label" for="new_ad_no">No</label>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <p class="text-muted mb-0">All users must have an email account.</p>
            <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
          </div>
        </form>
      <?php endif; ?>

      <?php if ($view === 'modify'): ?>
        <h2 class="h4 mb-3">Modify existing account request</h2>
        <form method="post" novalidate>
          <input type="hidden" name="form_type" value="modify">

          <div class="section-card mb-4">
            <div class="section-title mb-3">Requester</div>
            <div class="row g-3">
              <div class="col-md-6">
                <label for="requester_email" class="form-label">Requester Email</label>
                <input type="email" class="form-control" id="requester_email" name="requester_email" value="<?= h($requester_email) ?>" required>
                <div class="form-text">This is used as the sender address.</div>
              </div>
              <div class="col-md-6">
                <label for="requester_library" class="form-label">Library</label>
                <select class="form-select" id="requester_library" name="requester_library" required>
                  <option value="" <?= $requester_library === '' ? 'selected' : '' ?>>Select a library</option>
                  <?php foreach ($libraries as $library): ?>
                    <option value="<?= h($library) ?>" <?= $requester_library === $library ? 'selected' : '' ?>><?= h($library) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-12">
                <label for="requester_notes" class="form-label">Notes (optional)</label>
                <textarea class="form-control" id="requester_notes" name="requester_notes" rows="3"><?= h($requester_notes) ?></textarea>
              </div>
            </div>
          </div>

          <div class="section-card mb-4">
            <div class="section-title mb-3">Email Account</div>
            <div class="row g-3 align-items-end">
              <div class="col-md-4">
                <label class="form-label">Change Email Account?</label>
                <div class="d-flex gap-3">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="mod_change_email" id="mod_change_email_yes" value="Yes" <?= $mod_change_email === 'Yes' ? 'checked' : '' ?> required>
                    <label class="form-check-label" for="mod_change_email_yes">Yes</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="mod_change_email" id="mod_change_email_no" value="No" <?= $mod_change_email === 'No' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="mod_change_email_no">No</label>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mod-email-fields">
                <label for="mod_email_address" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="mod_email_address" name="mod_email_address" value="<?= h($mod_email_address) ?>">
              </div>
              <div class="col-12 mod-email-fields">
                <label class="form-label">Email Groups/Listservs (optional)</label>
                <div class="d-flex flex-wrap gap-3">
                  <?php foreach ($listservs as $listserv): ?>
                    <?php $listserv_id = 'mod_listserv_' . preg_replace('/[^a-z0-9]+/i', '_', strtolower($listserv)); ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="mod_email_groups[]" id="<?= h($listserv_id) ?>" value="<?= h($listserv) ?>" <?= in_array($listserv, $mod_email_groups, true) ? 'checked' : '' ?>>
                      <label class="form-check-label" for="<?= h($listserv_id) ?>"><?= h($listserv) ?></label>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
              <div class="col-12 mod-email-fields">
                <label for="mod_email_notes" class="form-label">Notes (optional)</label>
                <textarea class="form-control" id="mod_email_notes" name="mod_email_notes" rows="2"><?= h($mod_email_notes) ?></textarea>
              </div>
            </div>
          </div>

          <div class="section-card mb-4">
            <div class="section-title mb-3">Evergreen Account</div>
            <div class="row g-3 align-items-end">
              <div class="col-md-4">
                <label class="form-label">Change Evergreen Account?</label>
                <div class="d-flex gap-3">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="mod_change_evergreen" id="mod_change_evergreen_yes" value="Yes" <?= $mod_change_evergreen === 'Yes' ? 'checked' : '' ?> required>
                    <label class="form-check-label" for="mod_change_evergreen_yes">Yes</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="mod_change_evergreen" id="mod_change_evergreen_no" value="No" <?= $mod_change_evergreen === 'No' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="mod_change_evergreen_no">No</label>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mod-evergreen-fields">
                <label for="mod_evergreen_user_id" class="form-label">Evergreen User ID</label>
                <input type="text" class="form-control" id="mod_evergreen_user_id" name="mod_evergreen_user_id" value="<?= h($mod_evergreen_user_id) ?>">
              </div>
              <div class="col-md-4 mod-evergreen-fields">
                <label for="mod_evergreen_type" class="form-label">Account Type</label>
                <select class="form-select" id="mod_evergreen_type" name="mod_evergreen_type">
                  <option value="" <?= $mod_evergreen_type === '' ? 'selected' : '' ?>>Select type</option>
                  <?php foreach ($evergreen_account_types as $account_type): ?>
                    <option value="<?= h($account_type) ?>" <?= $mod_evergreen_type === $account_type ? 'selected' : '' ?>><?= h($account_type) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4 mod-evergreen-fields">
                <label class="form-label">Item Cataloging Add-on</label>
                <div class="d-flex gap-3">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="mod_cataloging_addon" id="mod_cataloging_yes" value="Yes" <?= $mod_cataloging_addon === 'Yes' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="mod_cataloging_yes">Yes</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="mod_cataloging_addon" id="mod_cataloging_no" value="No" <?= $mod_cataloging_addon === 'No' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="mod_cataloging_no">No</label>
                  </div>
                </div>
              </div>
              <div class="col-12 mod-evergreen-fields">
                <label for="mod_evergreen_notes" class="form-label">Notes (optional)</label>
                <textarea class="form-control" id="mod_evergreen_notes" name="mod_evergreen_notes" rows="2"><?= h($mod_evergreen_notes) ?></textarea>
              </div>
            </div>
          </div>

          <div class="section-card mb-4">
            <div class="section-title mb-2">Active Directory</div>
            <p class="form-text mb-3">Active Directory is required if the user needs to login to a library staff computer with a personal account.</p>
            <div class="row g-3 align-items-end">
              <div class="col-md-4">
                <label class="form-label">Change Active Directory Account?</label>
                <div class="d-flex gap-3">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="mod_change_ad" id="mod_change_ad_yes" value="Yes" <?= $mod_change_ad === 'Yes' ? 'checked' : '' ?> required>
                    <label class="form-check-label" for="mod_change_ad_yes">Yes</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="mod_change_ad" id="mod_change_ad_no" value="No" <?= $mod_change_ad === 'No' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="mod_change_ad_no">No</label>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mod-ad-fields">
                <label for="mod_ad_user_id" class="form-label">Active Directory User ID</label>
                <input type="text" class="form-control" id="mod_ad_user_id" name="mod_ad_user_id" value="<?= h($mod_ad_user_id) ?>">
              </div>
              <div class="col-12 mod-ad-fields">
                <label for="mod_ad_notes" class="form-label">Please describe the change (optional)</label>
                <textarea class="form-control" id="mod_ad_notes" name="mod_ad_notes" rows="2"><?= h($mod_ad_notes) ?></textarea>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
          </div>
        </form>
      <?php endif; ?>
    </main>

    <script src="assets/js/form.js"></script>
  </body>
</html>
