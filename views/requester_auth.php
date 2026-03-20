<?php $show_requester_notes = isset($show_requester_notes) ? (bool) $show_requester_notes : true; ?>
<div class="section-card mb-4">
  <div class="section-title mb-3">Requester</div>
  <div class="row g-3 align-items-start">
    <div class="<?= $requester_verified ? 'col-md-12' : 'col-md-6' ?>">
      <label for="requester_email" class="form-label">Requester Email</label>
      <input type="email" class="form-control" id="requester_email" name="requester_email" value="<?= h($requester_email) ?>" required>
      <?php if (!$requester_verified): ?>
        <div class="form-text">Only approved organization domains can authenticate.</div>
      <?php endif; ?>
      <?php if ($requester_verified): ?>
        <div class="mt-2">
          <span class="badge text-bg-success">Verified for this session</span>
        </div>
      <?php endif; ?>
    </div>
    <?php if (!$requester_verified): ?>
      <div class="col-md-6">
        <label for="otp_code" class="form-label">OTP Code</label>
        <input type="text" class="form-control" id="otp_code" name="otp_code" inputmode="numeric" maxlength="6" placeholder="Enter 6-digit code">
      </div>
      <div class="col-12 d-flex flex-wrap gap-2">
        <?php if (!$otp_sent): ?>
          <button type="submit" class="btn btn-primary" name="auth_action" value="send_otp" formnovalidate>Send OTP Code</button>
        <?php else: ?>
          <button type="submit" class="btn btn-outline-secondary" name="auth_action" value="send_otp" formnovalidate>Resend OTP Code</button>
          <button type="submit" class="btn btn-primary" name="auth_action" value="verify_otp" formnovalidate>Verify OTP Code</button>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>

  <?php if ($requester_verified): ?>
    <div class="row g-3 mt-1">
      <div class="col-md-6">
        <label for="requester_library" class="form-label">Library</label>
        <select class="form-select" id="requester_library" name="requester_library" required>
          <option value="" <?= $requester_library === '' ? 'selected' : '' ?>>Select A Library</option>
          <?php foreach ($libraries as $library_code => $library_name): ?>
            <option value="<?= h((string) $library_code) ?>" <?= $requester_library === (string) $library_code ? 'selected' : '' ?>><?= h((string) $library_name) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <?php if ($show_requester_notes): ?>
        <div class="col-12">
          <label for="requester_notes" class="form-label">Notes (optional)</label>
          <textarea class="form-control" id="requester_notes" name="requester_notes" rows="3"><?= h($requester_notes) ?></textarea>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>
