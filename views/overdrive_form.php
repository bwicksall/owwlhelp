<h2 class="h4 mb-3">Overdrive account merge</h2>
<form method="post" novalidate>
  <input type="hidden" name="form_type" value="overdrive">
  <?php require __DIR__ . '/requester_auth.php'; ?>

  <?php if (!$requester_verified): ?>
    <div class="alert alert-info">Verify your email address to unlock the rest of this form.</div>
  <?php endif; ?>

  <?php if ($requester_verified): ?>
    <div class="section-card mb-4">
      <div class="section-title mb-3">Account Information</div>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="od_patron_last_name" class="form-label">Patron Last Name</label>
          <input type="text" class="form-control" id="od_patron_last_name" name="od_patron_last_name" value="<?= h($od_patron_last_name) ?>" required>
        </div>
        <div class="col-md-6">
          <label for="od_new_card_number" class="form-label">New Library Card Number</label>
          <input type="text" class="form-control" id="od_new_card_number" name="od_new_card_number" value="<?= h($od_new_card_number) ?>" required>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
    </div>
  <?php endif; ?>
</form>
