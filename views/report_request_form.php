<?php $show_requester_notes = false; ?>
<h2 class="h4 mb-3">Request a report</h2>
<form method="post" novalidate>
  <input type="hidden" name="form_type" value="report_request">
  <?php require __DIR__ . '/requester_auth.php'; ?>

  <?php if (!$requester_verified): ?>
    <div class="alert alert-info">Verify your email address to unlock the rest of this form.</div>
  <?php endif; ?>

  <?php if ($requester_verified): ?>
    <div class="section-card mb-4">
      <div class="section-title mb-3">Report Request</div>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="er_select_report" class="form-label">Select Report</label>
          <select class="form-select" id="er_select_report" name="er_select_report" required>
            <option value="" <?= $er_select_report === '' ? 'selected' : '' ?>>Select report</option>
            <option value="Need Custom Report" <?= $er_select_report === 'Need Custom Report' ? 'selected' : '' ?>>Need Custom Report</option>
            <option value="Detailed Cash Report" <?= $er_select_report === 'Detailed Cash Report' ? 'selected' : '' ?>>Detailed Cash Report</option>
            <option value="Magazine Annual Circ" <?= $er_select_report === 'Magazine Annual Circ' ? 'selected' : '' ?>>Magazine Annual Circ</option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="er_deadline" class="form-label">Deadline (optional)</label>
          <input type="date" class="form-control" id="er_deadline" name="er_deadline" value="<?= h($er_deadline) ?>">
        </div>
        <div class="col-12">
          <label for="er_custom_report_description" class="form-label">Custom Report Detailed Description (optional)</label>
          <textarea class="form-control" id="er_custom_report_description" name="er_custom_report_description" rows="4"><?= h($er_custom_report_description) ?></textarea>
        </div>
        <div class="col-12">
          <label for="er_other_comments" class="form-label">Other Comments (optional)</label>
          <textarea class="form-control" id="er_other_comments" name="er_other_comments" rows="4"><?= h($er_other_comments) ?></textarea>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
    </div>
  <?php endif; ?>
</form>
