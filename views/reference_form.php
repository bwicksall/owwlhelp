<?php $show_requester_notes = false; ?>
<h2 class="h4 mb-3">Ask a reference question</h2>
<form method="post" novalidate>
  <input type="hidden" name="form_type" value="reference">
  <?php require __DIR__ . '/requester_auth.php'; ?>

  <?php if (!$requester_verified): ?>
    <div class="alert alert-info">Verify your email address to unlock the rest of this form.</div>
  <?php endif; ?>

  <?php if ($requester_verified): ?>
    <div class="section-card mb-4">
      <div class="section-title mb-3">Request Details</div>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="ref_request_type" class="form-label">Request Type</label>
          <select class="form-select" id="ref_request_type" name="ref_request_type" required>
            <option value="" <?= $ref_request_type === '' ? 'selected' : '' ?>>Select request type</option>
            <option value="Information" <?= $ref_request_type === 'Information' ? 'selected' : '' ?>>Information</option>
            <option value="Subject" <?= $ref_request_type === 'Subject' ? 'selected' : '' ?>>Subject</option>
            <option value="Training" <?= $ref_request_type === 'Training' ? 'selected' : '' ?>>Training</option>
            <option value="Other" <?= $ref_request_type === 'Other' ? 'selected' : '' ?>>Other</option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="ref_subject_topic" class="form-label">Subject or Topic (optional)</label>
          <textarea class="form-control" id="ref_subject_topic" name="ref_subject_topic" rows="2"><?= h($ref_subject_topic) ?></textarea>
        </div>
        <div class="col-md-6">
          <label for="ref_sources_consulted" class="form-label">Sources Consulted (optional)</label>
          <textarea class="form-control" id="ref_sources_consulted" name="ref_sources_consulted" rows="2"><?= h($ref_sources_consulted) ?></textarea>
        </div>
        <div class="col-md-6">
          <label for="ref_notes_comments" class="form-label">Notes or Comments (optional)</label>
          <textarea class="form-control" id="ref_notes_comments" name="ref_notes_comments" rows="2"><?= h($ref_notes_comments) ?></textarea>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
    </div>
  <?php endif; ?>
</form>
