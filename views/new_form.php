<h2 class="h4 mb-3">New user account request</h2>
<form method="post" novalidate>
  <input type="hidden" name="form_type" value="new">
  <?php require __DIR__ . '/requester_auth.php'; ?>

  <?php if (!$requester_verified): ?>
    <div class="alert alert-info">Verify your requester email with OTP to unlock the rest of this form.</div>
  <?php endif; ?>

  <?php if ($requester_verified): ?>
    <div class="section-card mb-4">
      <div class="section-title mb-3">Email Account</div>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="new_user_name" class="form-label">User First and Last Name</label>
          <input type="text" class="form-control" id="new_user_name" name="new_user_name" value="<?= h($new_user_name) ?>" required>
        </div>
        <div class="col-md-6">
          <label for="new_start_date" class="form-label">Start Date</label>
          <input type="date" class="form-control" id="new_start_date" name="new_start_date" value="<?= h($new_start_date) ?>" required>
        </div>
        <div class="col-12">
          <label class="form-label">Email Groups/Listservs (optional)</label>
          <div class="d-flex flex-wrap gap-3">
            <?php foreach ($listservs as $listserv): ?>
              <?php $listserv_id = 'new_listserv_' . preg_replace('/[^a-z0-9]+/i', '_', strtolower($listserv)); ?>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="new_email_groups[]" id="<?= h($listserv_id) ?>" value="<?= h($listserv) ?>" <?= in_array($listserv, $new_email_groups, true) ? 'checked' : '' ?>>
                <label class="form-check-label" for="<?= h($listserv_id) ?>"><?= h($listserv) ?></label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="section-card mb-4">
      <div class="section-title mb-3">Evergreen Account</div>
      <div class="row g-3 align-items-end">
        <div class="col-md-4">
          <label class="form-label">Evergreen Required?</label>
          <div class="d-flex gap-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="new_evergreen_required" id="new_evergreen_yes" value="Yes" <?= $new_evergreen_required === 'Yes' ? 'checked' : '' ?> required>
              <label class="form-check-label" for="new_evergreen_yes">Yes</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="new_evergreen_required" id="new_evergreen_no" value="No" <?= $new_evergreen_required === 'No' ? 'checked' : '' ?>>
              <label class="form-check-label" for="new_evergreen_no">No</label>
            </div>
          </div>
        </div>
        <div class="col-md-4 new-evergreen-fields">
          <label for="new_evergreen_type" class="form-label">Account Type</label>
          <select class="form-select" id="new_evergreen_type" name="new_evergreen_type">
            <option value="" <?= $new_evergreen_type === '' ? 'selected' : '' ?>>Select type</option>
            <?php foreach ($evergreen_account_types as $account_type): ?>
              <option value="<?= h($account_type) ?>" <?= $new_evergreen_type === $account_type ? 'selected' : '' ?>><?= h($account_type) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4 new-evergreen-fields">
          <label class="form-label">Item Cataloging Add-on</label>
          <div class="d-flex gap-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="new_cataloging_addon" id="new_cataloging_yes" value="Yes" <?= $new_cataloging_addon === 'Yes' ? 'checked' : '' ?>>
              <label class="form-check-label" for="new_cataloging_yes">Yes</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="new_cataloging_addon" id="new_cataloging_no" value="No" <?= $new_cataloging_addon === 'No' ? 'checked' : '' ?>>
              <label class="form-check-label" for="new_cataloging_no">No</label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="section-card mb-4">
      <div class="section-title mb-2">Active Directory</div>
      <p class="form-text mb-3">Active Directory is required if the user needs to login to a library staff computer with a personal account.</p>
      <div class="d-flex gap-3">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="new_ad_required" id="new_ad_yes" value="Yes" <?= $new_ad_required === 'Yes' ? 'checked' : '' ?> required>
          <label class="form-check-label" for="new_ad_yes">Yes</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="new_ad_required" id="new_ad_no" value="No" <?= $new_ad_required === 'No' ? 'checked' : '' ?>>
          <label class="form-check-label" for="new_ad_no">No</label>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center">
      <p class="text-muted mb-0">All users must have an email account.</p>
      <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
    </div>
  <?php endif; ?>
</form>
