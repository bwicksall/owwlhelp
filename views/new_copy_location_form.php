<?php $show_requester_notes = false; ?>
<h2 class="h4 mb-3">Request new copy location</h2>
<form method="post" novalidate>
  <input type="hidden" name="form_type" value="new_copy_location">
  <?php require __DIR__ . '/requester_auth.php'; ?>

  <?php if (!$requester_verified): ?>
    <div class="alert alert-info">Verify your email address to unlock the rest of this form.</div>
  <?php endif; ?>

  <?php if ($requester_verified): ?>
    <div class="section-card mb-4">
      <div class="section-title mb-3">Location Details</div>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="ecl_location_name" class="form-label">Location Name</label>
          <input type="text" class="form-control" id="ecl_location_name" name="ecl_location_name" value="<?= h($ecl_location_name) ?>" required>
        </div>
        <div class="col-md-2">
          <label for="ecl_opac_visible" class="form-label">OPAC Visible</label>
          <select class="form-select" id="ecl_opac_visible" name="ecl_opac_visible" required>
            <option value="" <?= $ecl_opac_visible === '' ? 'selected' : '' ?>>--</option>
            <option value="Yes" <?= $ecl_opac_visible === 'Yes' ? 'selected' : '' ?>>Yes</option>
            <option value="No" <?= $ecl_opac_visible === 'No' ? 'selected' : '' ?>>No</option>
          </select>
        </div>
        <div class="col-md-2">
          <label for="ecl_holdable" class="form-label">Holdable</label>
          <select class="form-select" id="ecl_holdable" name="ecl_holdable" required>
            <option value="" <?= $ecl_holdable === '' ? 'selected' : '' ?>>--</option>
            <option value="Yes" <?= $ecl_holdable === 'Yes' ? 'selected' : '' ?>>Yes</option>
            <option value="No" <?= $ecl_holdable === 'No' ? 'selected' : '' ?>>No</option>
          </select>
        </div>
        <div class="col-md-2">
          <label for="ecl_circulate" class="form-label">Circulate</label>
          <select class="form-select" id="ecl_circulate" name="ecl_circulate" required>
            <option value="" <?= $ecl_circulate === '' ? 'selected' : '' ?>>--</option>
            <option value="Yes" <?= $ecl_circulate === 'Yes' ? 'selected' : '' ?>>Yes</option>
            <option value="No" <?= $ecl_circulate === 'No' ? 'selected' : '' ?>>No</option>
          </select>
        </div>
        <div class="col-12">
          <label for="ecl_additional_comments" class="form-label">Additional Comments (optional)</label>
          <textarea class="form-control" id="ecl_additional_comments" name="ecl_additional_comments" rows="2"><?= h($ecl_additional_comments) ?></textarea>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
    </div>
  <?php endif; ?>
</form>
