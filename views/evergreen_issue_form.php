<?php $show_requester_notes = false; ?>
<h2 class="h4 mb-3">Report an Evergreen issue</h2>
<form method="post" novalidate>
  <input type="hidden" name="form_type" value="evergreen_issue">
  <?php require __DIR__ . '/requester_auth.php'; ?>

  <?php if (!$requester_verified): ?>
    <div class="alert alert-info">Verify your email address to unlock the rest of this form.</div>
  <?php endif; ?>

  <?php if ($requester_verified): ?>
    <div class="section-card mb-4">
      <div class="section-title mb-3">Request Details</div>
      <div class="row g-3">
        <div class="col-12">
          <label for="eg_issue" class="form-label">Request</label>
          <textarea class="form-control" id="eg_issue" name="eg_issue" rows="4" required><?= h($eg_issue) ?></textarea>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
    </div>
  <?php endif; ?>
</form>
