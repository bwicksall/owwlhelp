<?php $show_requester_notes = false; ?>
<h2 class="h4 mb-3">Delivery questions</h2>
<form method="post" novalidate>
  <input type="hidden" name="form_type" value="delivery">
  <?php require __DIR__ . '/requester_auth.php'; ?>

  <?php if (!$requester_verified): ?>
    <div class="alert alert-info">Verify your requester email with OTP to unlock the rest of this form.</div>
  <?php endif; ?>

  <?php if ($requester_verified): ?>
    <div class="section-card mb-4">
      <div class="section-title mb-3">Question</div>
      <div class="row g-3">
        <div class="col-12">
          <label for="delivery_question" class="form-label">Question</label>
          <textarea class="form-control" id="delivery_question" name="delivery_question" rows="4" required><?= h($delivery_question) ?></textarea>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
    </div>
  <?php endif; ?>
</form>
