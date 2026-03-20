<h2 class="h4 mb-3">Delete account request</h2>
<form method="post" novalidate>
  <input type="hidden" name="form_type" value="delete">
  <?php require __DIR__ . '/requester_auth.php'; ?>

  <?php if (!$requester_verified): ?>
    <div class="alert alert-info">Verify your email address to unlock the rest of this form.</div>
  <?php endif; ?>

  <?php if ($requester_verified): ?>
  <div class="section-card mb-4">
    <div class="section-title mb-3">Account To Delete</div>
    <div class="row g-3">
      <div class="col-md-4">
        <label for="del_user_id" class="form-label">User ID</label>
        <input type="text" class="form-control" id="del_user_id" name="del_user_id" value="<?= h($del_user_id) ?>" required>
      </div>
      <div class="col-md-4">
        <label for="del_full_name" class="form-label">Full Name (optional)</label>
        <input type="text" class="form-control" id="del_full_name" name="del_full_name" value="<?= h($del_full_name) ?>">
      </div>
      <div class="col-md-4">
        <label for="del_last_day" class="form-label">User Last Day</label>
        <input type="date" class="form-control" id="del_last_day" name="del_last_day" value="<?= h($del_last_day) ?>" required>
      </div>
    </div>
  </div>

  <div class="section-card mb-4">
    <div class="section-title mb-3">Email Forwarding</div>
    <div class="row g-3 align-items-start">
      <div class="col-md-12 col-lg-5">
        <label class="form-label text-nowrap">Forward to another account for 60 days?</label>
        <div class="d-flex gap-3">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="del_forward_email" id="del_forward_yes" value="Yes" <?= $del_forward_email === 'Yes' ? 'checked' : '' ?> required>
            <label class="form-check-label" for="del_forward_yes">Yes</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="del_forward_email" id="del_forward_no" value="No" <?= $del_forward_email === 'No' ? 'checked' : '' ?>>
            <label class="form-check-label" for="del_forward_no">No</label>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-lg-7 del-forward-fields">
        <label for="del_forward_target" class="form-label">Target Email Address</label>
        <input type="email" class="form-control" id="del_forward_target" name="del_forward_target" value="<?= h($del_forward_target) ?>">
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-end">
    <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
  </div>
  <?php endif; ?>
</form>
