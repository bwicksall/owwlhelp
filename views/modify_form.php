<h2 class="h4 mb-3">Modify existing account request</h2>
<form method="post" novalidate>
  <input type="hidden" name="form_type" value="modify">

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
    <div class="section-title mb-3">Email Account</div>
    <div class="row g-3 align-items-end">
      <div class="col-md-4">
        <label class="form-label">Change Email Account?</label>
        <div class="d-flex gap-3">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="mod_change_email" id="mod_change_email_yes" value="Yes" <?= $mod_change_email === 'Yes' ? 'checked' : '' ?> required>
            <label class="form-check-label" for="mod_change_email_yes">Yes</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="mod_change_email" id="mod_change_email_no" value="No" <?= $mod_change_email === 'No' ? 'checked' : '' ?>>
            <label class="form-check-label" for="mod_change_email_no">No</label>
          </div>
        </div>
      </div>
      <div class="col-md-4 mod-email-fields">
        <label for="mod_email_address" class="form-label">Email Address</label>
        <input type="email" class="form-control" id="mod_email_address" name="mod_email_address" value="<?= h($mod_email_address) ?>">
      </div>
      <div class="col-12 mod-email-fields">
        <label class="form-label">Email Groups/Listservs (optional)</label>
        <div class="d-flex flex-wrap gap-3">
          <?php foreach ($listservs as $listserv): ?>
            <?php $listserv_id = 'mod_listserv_' . preg_replace('/[^a-z0-9]+/i', '_', strtolower($listserv)); ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="mod_email_groups[]" id="<?= h($listserv_id) ?>" value="<?= h($listserv) ?>" <?= in_array($listserv, $mod_email_groups, true) ? 'checked' : '' ?>>
              <label class="form-check-label" for="<?= h($listserv_id) ?>"><?= h($listserv) ?></label>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="col-12 mod-email-fields">
        <label for="mod_email_notes" class="form-label">Notes (optional)</label>
        <textarea class="form-control" id="mod_email_notes" name="mod_email_notes" rows="2"><?= h($mod_email_notes) ?></textarea>
      </div>
    </div>
  </div>

  <div class="section-card mb-4">
    <div class="section-title mb-3">Evergreen Account</div>
    <div class="row g-3 align-items-end">
      <div class="col-md-4">
        <label class="form-label">Change Evergreen Account?</label>
        <div class="d-flex gap-3">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="mod_change_evergreen" id="mod_change_evergreen_yes" value="Yes" <?= $mod_change_evergreen === 'Yes' ? 'checked' : '' ?> required>
            <label class="form-check-label" for="mod_change_evergreen_yes">Yes</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="mod_change_evergreen" id="mod_change_evergreen_no" value="No" <?= $mod_change_evergreen === 'No' ? 'checked' : '' ?>>
            <label class="form-check-label" for="mod_change_evergreen_no">No</label>
          </div>
        </div>
      </div>
      <div class="col-md-4 mod-evergreen-fields">
        <label for="mod_evergreen_user_id" class="form-label">Evergreen User ID</label>
        <input type="text" class="form-control" id="mod_evergreen_user_id" name="mod_evergreen_user_id" value="<?= h($mod_evergreen_user_id) ?>">
      </div>
      <div class="col-md-4 mod-evergreen-fields">
        <label for="mod_evergreen_type" class="form-label">Account Type</label>
        <select class="form-select" id="mod_evergreen_type" name="mod_evergreen_type">
          <option value="" <?= $mod_evergreen_type === '' ? 'selected' : '' ?>>Select type</option>
          <?php foreach ($evergreen_account_types as $account_type): ?>
            <option value="<?= h($account_type) ?>" <?= $mod_evergreen_type === $account_type ? 'selected' : '' ?>><?= h($account_type) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4 mod-evergreen-fields">
        <label class="form-label">Item Cataloging Add-on</label>
        <div class="d-flex gap-3">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="mod_cataloging_addon" id="mod_cataloging_yes" value="Yes" <?= $mod_cataloging_addon === 'Yes' ? 'checked' : '' ?>>
            <label class="form-check-label" for="mod_cataloging_yes">Yes</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="mod_cataloging_addon" id="mod_cataloging_no" value="No" <?= $mod_cataloging_addon === 'No' ? 'checked' : '' ?>>
            <label class="form-check-label" for="mod_cataloging_no">No</label>
          </div>
        </div>
      </div>
      <div class="col-12 mod-evergreen-fields">
        <label for="mod_evergreen_notes" class="form-label">Notes (optional)</label>
        <textarea class="form-control" id="mod_evergreen_notes" name="mod_evergreen_notes" rows="2"><?= h($mod_evergreen_notes) ?></textarea>
      </div>
    </div>
  </div>

  <div class="section-card mb-4">
    <div class="section-title mb-2">Active Directory</div>
    <p class="form-text mb-3">Active Directory is required if the user needs to login to a library staff computer with a personal account.</p>
    <div class="row g-3 align-items-end">
      <div class="col-md-4">
        <label class="form-label">Change Active Directory Account?</label>
        <div class="d-flex gap-3">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="mod_change_ad" id="mod_change_ad_yes" value="Yes" <?= $mod_change_ad === 'Yes' ? 'checked' : '' ?> required>
            <label class="form-check-label" for="mod_change_ad_yes">Yes</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="mod_change_ad" id="mod_change_ad_no" value="No" <?= $mod_change_ad === 'No' ? 'checked' : '' ?>>
            <label class="form-check-label" for="mod_change_ad_no">No</label>
          </div>
        </div>
      </div>
      <div class="col-md-4 mod-ad-fields">
        <label for="mod_ad_user_id" class="form-label">Active Directory User ID</label>
        <input type="text" class="form-control" id="mod_ad_user_id" name="mod_ad_user_id" value="<?= h($mod_ad_user_id) ?>">
      </div>
      <div class="col-12 mod-ad-fields">
        <label for="mod_ad_notes" class="form-label">Please describe the change (optional)</label>
        <textarea class="form-control" id="mod_ad_notes" name="mod_ad_notes" rows="2"><?= h($mod_ad_notes) ?></textarea>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-end">
    <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
  </div>
</form>
