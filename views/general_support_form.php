<?php $show_requester_notes = false; ?>
<h2 class="h4 mb-3">General support</h2>
<form method="post" novalidate>
  <input type="hidden" name="form_type" value="general_support">
  <?php require __DIR__ . '/requester_auth.php'; ?>

  <?php if (!$requester_verified): ?>
    <div class="alert alert-info">Verify your email address to unlock the rest of this form.</div>
  <?php endif; ?>

  <?php if ($requester_verified): ?>
    <div class="section-card mb-4">
      <div class="section-title mb-3">Support Request</div>
      <div class="row g-3">
        <div class="col-12">
          <label for="ts_subject" class="form-label">Subject</label>
          <input type="text" class="form-control" id="ts_subject" name="ts_subject" value="<?= h($ts_subject) ?>" required>
        </div>
        <div class="col-12">
          <label for="ts_description" class="form-label">Description</label>
          <textarea class="form-control" id="ts_description" name="ts_description" rows="4" required><?= h($ts_description) ?></textarea>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
    </div>
  <?php endif; ?>
</form>
