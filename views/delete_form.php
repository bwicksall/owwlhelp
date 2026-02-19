<h2 class="h4 mb-3">Delete account request</h2>
<form method="post" novalidate>
  <input type="hidden" name="form_type" value="delete">

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
    <div class="row g-3 align-items-end">
      <div class="col-md-4">
        <label class="form-label">Forward to another account for 60 days?</label>
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
      <div class="col-md-6 del-forward-fields">
        <label for="del_forward_target" class="form-label">Target Email Address</label>
        <input type="email" class="form-control" id="del_forward_target" name="del_forward_target" value="<?= h($del_forward_target) ?>">
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-end">
    <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
  </div>
</form>
