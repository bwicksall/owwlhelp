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
      <div class="section-title mb-3">Issue Details</div>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="eg_problem_type" class="form-label">Problem Type</label>
          <select class="form-select" id="eg_problem_type" name="eg_problem_type" required>
            <option value="" <?= $eg_problem_type === '' ? 'selected' : '' ?>>Select problem type</option>
            <option value="Bills" <?= $eg_problem_type === 'Bills' ? 'selected' : '' ?>>Bills</option>
            <option value="Circulation" <?= $eg_problem_type === 'Circulation' ? 'selected' : '' ?>>Circulation</option>
            <option value="Fines" <?= $eg_problem_type === 'Fines' ? 'selected' : '' ?>>Fines</option>
            <option value="Holdings Maintenance" <?= $eg_problem_type === 'Holdings Maintenance' ? 'selected' : '' ?>>Holdings Maintenance</option>
            <option value="Holds" <?= $eg_problem_type === 'Holds' ? 'selected' : '' ?>>Holds</option>
            <option value="Network Errors" <?= $eg_problem_type === 'Network Errors' ? 'selected' : '' ?>>Network Errors</option>
            <option value="Notifications" <?= $eg_problem_type === 'Notifications' ? 'selected' : '' ?>>Notifications</option>
            <option value="OPAC" <?= $eg_problem_type === 'OPAC' ? 'selected' : '' ?>>OPAC</option>
            <option value="Overdues" <?= $eg_problem_type === 'Overdues' ? 'selected' : '' ?>>Overdues</option>
            <option value="Printing" <?= $eg_problem_type === 'Printing' ? 'selected' : '' ?>>Printing</option>
            <option value="Reports" <?= $eg_problem_type === 'Reports' ? 'selected' : '' ?>>Reports</option>
            <option value="Staff Client (general)" <?= $eg_problem_type === 'Staff Client (general)' ? 'selected' : '' ?>>Staff Client (general)</option>
            <option value="Web Client" <?= $eg_problem_type === 'Web Client' ? 'selected' : '' ?>>Web Client</option>
            <option value="Other (Specify in the &quot;Issue&quot; box)" <?= $eg_problem_type === 'Other (Specify in the "Issue" box)' ? 'selected' : '' ?>>Other (Specify in the "Issue" box)</option>
          </select>
        </div>
        <div class="col-12">
          <label for="eg_issue" class="form-label">Issue</label>
          <textarea class="form-control" id="eg_issue" name="eg_issue" rows="4" required><?= h($eg_issue) ?></textarea>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
    </div>
  <?php endif; ?>
</form>
