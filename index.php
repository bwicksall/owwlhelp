<?php
$errors = [];
$success_message = '';

function post_value(string $key): string {
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : '';
}

function is_checked(string $key, string $value): bool {
    return isset($_POST[$key]) && $_POST[$key] === $value;
}

$email = post_value('email');
$library = post_value('library');
$user_name = post_value('user_name');
$start_date = post_value('start_date');
$evergreen_required = post_value('evergreen_required');
$evergreen_type = post_value('evergreen_type');
$cataloging_addon = post_value('cataloging_addon');
$ad_required = post_value('ad_required');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($library === '') {
        $errors[] = 'Please select a library.';
    }

    if ($user_name === '') {
        $errors[] = 'Please enter the user’s first and last name.';
    }

    if ($start_date === '') {
        $errors[] = 'Please select a start date.';
    }

    if ($evergreen_required !== 'Yes' && $evergreen_required !== 'No') {
        $errors[] = 'Please indicate whether an Evergreen account is required.';
    }

    if ($evergreen_required === 'Yes') {
        if ($evergreen_type === '') {
            $errors[] = 'Please select an Evergreen account type.';
        }
        if ($cataloging_addon !== 'Yes' && $cataloging_addon !== 'No') {
            $cataloging_addon = 'No';
        }
    }

    if ($ad_required !== 'Yes' && $ad_required !== 'No') {
        $errors[] = 'Please indicate whether an Active Directory account is needed.';
    }

    if (!$errors) {
        $subject = 'OWWL Help - New User Account Request';

        $lines = [
            "Ticket Type: New User Account",
            "Requester Email: {$email}",
            "Library: {$library}",
            "User Name: {$user_name}",
            "Start Date: {$start_date}",
            "Evergreen Account Required: {$evergreen_required}",
        ];

        if ($evergreen_required === 'Yes') {
            $lines[] = "Evergreen Account Type: {$evergreen_type}";
            $lines[] = "Item Cataloging Add-on Needed: {$cataloging_addon}";
        }

        $lines[] = "Active Directory Account Needed: {$ad_required}";

        $message = implode("\n", $lines);
        $headers = "From: {$email}\r\nReply-To: {$email}\r\n";

        $mail_sent = @mail('bwicksall@owwl.org', $subject, $message, $headers);

        if ($mail_sent) {
            $success_message = 'Your request has been sent.';
            $_POST = [];
            $email = $library = $user_name = $start_date = $evergreen_required = $evergreen_type = $cataloging_addon = $ad_required = '';
        } else {
            $errors[] = 'Your request could not be sent. Please try again or contact support.';
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $cataloging_addon === '') {
    $cataloging_addon = 'No';
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OWWL Help - New User Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      :root {
        --owwl-ink: #1e2a32;
        --owwl-sea: #0f627b;
        --owwl-mist: #e7f2f6;
      }
      body {
        background: linear-gradient(120deg, #f7fbfd 0%, var(--owwl-mist) 100%);
        color: var(--owwl-ink);
        font-family: "Source Serif 4", "Georgia", serif;
      }
      .page-shell {
        max-width: 900px;
        margin: 3rem auto;
        padding: 2.5rem 2.75rem;
        background: white;
        border-radius: 18px;
        box-shadow: 0 20px 45px rgba(17, 35, 45, 0.12);
      }
      h1, h2, h3, label {
        font-family: "Plus Jakarta Sans", "Segoe UI", sans-serif;
      }
      .section-card {
        padding: 1.5rem;
        border-radius: 14px;
        background: #f9fcfd;
        border: 1px solid rgba(15, 98, 123, 0.12);
      }
      .section-title {
        color: var(--owwl-sea);
        font-size: 1.1rem;
        letter-spacing: 0.02em;
        text-transform: uppercase;
      }
      .btn-primary {
        background-color: var(--owwl-sea);
        border-color: var(--owwl-sea);
      }
      .btn-primary:hover {
        background-color: #0b5166;
        border-color: #0b5166;
      }
      .form-text {
        color: #51616b;
      }
    </style>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600&family=Source+Serif+4:wght@400;600&display=swap">
  </head>
  <body>
    <main class="page-shell">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
        <div>
          <h1 class="h2 mb-2">OWWL Help</h1>
          <p class="mb-0 text-muted">New user account request form</p>
        </div>
        <div class="badge text-bg-light border border-1">Ticketing Front End</div>
      </div>

      <?php if ($errors): ?>
        <div class="alert alert-danger">
          <strong>There were problems with your submission:</strong>
          <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
              <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <?php if ($success_message): ?>
        <div class="alert alert-success">
          <?= htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8') ?>
        </div>
      <?php endif; ?>

      <form method="post" novalidate>
        <div class="section-card mb-4">
          <div class="section-title mb-3">Requester</div>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="email" class="form-label">Requester Email</label>
              <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" required>
              <div class="form-text">This will be used as the sender address.</div>
            </div>
            <div class="col-md-6">
              <label for="library" class="form-label">Library</label>
              <select class="form-select" id="library" name="library" required>
                <option value="" <?= $library === '' ? 'selected' : '' ?>>Select a library</option>
                <option value="Test Library 1" <?= $library === 'Test Library 1' ? 'selected' : '' ?>>Test Library 1</option>
                <option value="Test Library 2" <?= $library === 'Test Library 2' ? 'selected' : '' ?>>Test Library 2</option>
              </select>
            </div>
          </div>
        </div>

        <div class="section-card mb-4">
          <div class="section-title mb-3">Email Account</div>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="user_name" class="form-label">User First and Last Name</label>
              <input type="text" class="form-control" id="user_name" name="user_name" value="<?= htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="col-md-6">
              <label for="start_date" class="form-label">Start Date</label>
              <input type="date" class="form-control" id="start_date" name="start_date" value="<?= htmlspecialchars($start_date, ENT_QUOTES, 'UTF-8') ?>" required>
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
                  <input class="form-check-input" type="radio" name="evergreen_required" id="evergreen_yes" value="Yes" <?= is_checked('evergreen_required', 'Yes') ? 'checked' : '' ?> required>
                  <label class="form-check-label" for="evergreen_yes">Yes</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="evergreen_required" id="evergreen_no" value="No" <?= is_checked('evergreen_required', 'No') ? 'checked' : '' ?>>
                  <label class="form-check-label" for="evergreen_no">No</label>
                </div>
              </div>
            </div>
            <div class="col-md-4 evergreen-fields">
              <label for="evergreen_type" class="form-label">Account Type</label>
              <select class="form-select" id="evergreen_type" name="evergreen_type">
                <option value="" <?= $evergreen_type === '' ? 'selected' : '' ?>>Select type</option>
                <option value="Basic (No Circ)" <?= $evergreen_type === 'Basic (No Circ)' ? 'selected' : '' ?>>Basic (No Circ)</option>
                <option value="Circ I" <?= $evergreen_type === 'Circ I' ? 'selected' : '' ?>>Circ I</option>
                <option value="Circ II" <?= $evergreen_type === 'Circ II' ? 'selected' : '' ?>>Circ II</option>
              </select>
            </div>
            <div class="col-md-4 evergreen-fields">
              <label class="form-label">Item Cataloging Add-on</label>
              <div class="d-flex gap-3">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="cataloging_addon" id="cataloging_yes" value="Yes" <?= $cataloging_addon === 'Yes' ? 'checked' : '' ?>>
                  <label class="form-check-label" for="cataloging_yes">Yes</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="cataloging_addon" id="cataloging_no" value="No" <?= $cataloging_addon === 'No' ? 'checked' : '' ?>>
                  <label class="form-check-label" for="cataloging_no">No</label>
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
              <input class="form-check-input" type="radio" name="ad_required" id="ad_yes" value="Yes" <?= is_checked('ad_required', 'Yes') ? 'checked' : '' ?> required>
              <label class="form-check-label" for="ad_yes">Yes</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="ad_required" id="ad_no" value="No" <?= is_checked('ad_required', 'No') ? 'checked' : '' ?>>
              <label class="form-check-label" for="ad_no">No</label>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
          <p class="text-muted mb-0">All users must have an email account.</p>
          <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
        </div>
      </form>
    </main>

    <script>
      const evergreenYes = document.getElementById('evergreen_yes');
      const evergreenNo = document.getElementById('evergreen_no');
      const evergreenFields = document.querySelectorAll('.evergreen-fields');

      function toggleEvergreenFields() {
        const show = evergreenYes.checked;
        evergreenFields.forEach((field) => {
          field.style.display = show ? 'block' : 'none';
        });
      }

      evergreenYes.addEventListener('change', toggleEvergreenFields);
      evergreenNo.addEventListener('change', toggleEvergreenFields);
      toggleEvergreenFields();
    </script>
  </body>
</html>
