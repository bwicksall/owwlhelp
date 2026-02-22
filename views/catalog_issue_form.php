<?php $show_requester_notes = false; ?>
<h2 class="h4 mb-3">Report a catalog issue</h2>
<form method="post" novalidate>
  <input type="hidden" name="form_type" value="catalog_issue">
  <?php require __DIR__ . '/requester_auth.php'; ?>

  <?php if (!$requester_verified): ?>
    <div class="alert alert-info">Verify your requester email with OTP to unlock the rest of this form.</div>
  <?php endif; ?>

  <?php if ($requester_verified): ?>
    <div class="section-card mb-4">
      <div class="section-title mb-3">Issue Details</div>
      <div class="row g-3">
        <div class="col-md-4">
          <label for="cat_problem" class="form-label">Problem</label>
          <select class="form-select" id="cat_problem" name="cat_problem" required>
            <option value="" <?= $cat_problem === '' ? 'selected' : '' ?>>Select problem</option>
            <option value="Title Error" <?= $cat_problem === 'Title Error' ? 'selected' : '' ?>>Title Error</option>
            <option value="Add ISBN or UPC" <?= $cat_problem === 'Add ISBN or UPC' ? 'selected' : '' ?>>Add ISBN or UPC</option>
            <option value="Page and CM" <?= $cat_problem === 'Page and CM' ? 'selected' : '' ?>>Page and CM</option>
            <option value="Replace Record" <?= $cat_problem === 'Replace Record' ? 'selected' : '' ?>>Replace Record</option>
            <option value="Merge Record" <?= $cat_problem === 'Merge Record' ? 'selected' : '' ?>>Merge Record</option>
            <option value="Field Error" <?= $cat_problem === 'Field Error' ? 'selected' : '' ?>>Field Error</option>
            <option value="Other" <?= $cat_problem === 'Other' ? 'selected' : '' ?>>Other</option>
          </select>
        </div>
        <div class="col-md-4">
          <label for="cat_material_type" class="form-label">Material Type (optional)</label>
          <select class="form-select" id="cat_material_type" name="cat_material_type">
            <option value="" <?= $cat_material_type === '' ? 'selected' : '' ?>>Select material type</option>
            <option value="Book" <?= $cat_material_type === 'Book' ? 'selected' : '' ?>>Book</option>
            <option value="CD" <?= $cat_material_type === 'CD' ? 'selected' : '' ?>>CD</option>
            <option value="DVD" <?= $cat_material_type === 'DVD' ? 'selected' : '' ?>>DVD</option>
            <option value="Other" <?= $cat_material_type === 'Other' ? 'selected' : '' ?>>Other</option>
          </select>
        </div>
        <div class="col-md-4">
          <label for="cat_format" class="form-label">Format (optional)</label>
          <select class="form-select" id="cat_format" name="cat_format">
            <option value="" <?= $cat_format === '' ? 'selected' : '' ?>>Select format</option>
            <option value="Large Print" <?= $cat_format === 'Large Print' ? 'selected' : '' ?>>Large Print</option>
            <option value="Regular Print" <?= $cat_format === 'Regular Print' ? 'selected' : '' ?>>Regular Print</option>
            <option value="Unabridged" <?= $cat_format === 'Unabridged' ? 'selected' : '' ?>>Unabridged</option>
            <option value="Abridged" <?= $cat_format === 'Abridged' ? 'selected' : '' ?>>Abridged</option>
            <option value="Widescreen" <?= $cat_format === 'Widescreen' ? 'selected' : '' ?>>Widescreen</option>
            <option value="Full Screen" <?= $cat_format === 'Full Screen' ? 'selected' : '' ?>>Full Screen</option>
            <option value="Other" <?= $cat_format === 'Other' ? 'selected' : '' ?>>Other</option>
          </select>
        </div>
        <div class="col-12">
          <label for="cat_description" class="form-label">Description</label>
          <textarea class="form-control" id="cat_description" name="cat_description" rows="2" required><?= h($cat_description) ?></textarea>
        </div>
        <div class="col-md-6">
          <label for="cat_author" class="form-label">Author (optional)</label>
          <input type="text" class="form-control" id="cat_author" name="cat_author" value="<?= h($cat_author) ?>">
        </div>
        <div class="col-md-6">
          <label for="cat_title" class="form-label">Title (optional)</label>
          <input type="text" class="form-control" id="cat_title" name="cat_title" value="<?= h($cat_title) ?>">
        </div>
        <div class="col-md-4">
          <label for="cat_publisher" class="form-label">Publisher (optional)</label>
          <input type="text" class="form-control" id="cat_publisher" name="cat_publisher" value="<?= h($cat_publisher) ?>">
        </div>
        <div class="col-md-4">
          <label for="cat_year" class="form-label">Year (optional)</label>
          <input type="text" class="form-control" id="cat_year" name="cat_year" value="<?= h($cat_year) ?>">
        </div>
        <div class="col-md-4">
          <label for="cat_isbn_ups" class="form-label">ISBN or UPS (optional)</label>
          <input type="text" class="form-control" id="cat_isbn_ups" name="cat_isbn_ups" value="<?= h($cat_isbn_ups) ?>">
        </div>
        <div class="col-12">
          <label for="cat_additional_comments" class="form-label">Additional Comments (optional)</label>
          <textarea class="form-control" id="cat_additional_comments" name="cat_additional_comments" rows="2"><?= h($cat_additional_comments) ?></textarea>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
    </div>
  <?php endif; ?>
</form>
