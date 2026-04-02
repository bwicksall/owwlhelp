<?php $show_requester_notes = false; ?>
<h2 class="h4 mb-3">Request original cataloging</h2>
<form method="post" novalidate>
  <input type="hidden" name="form_type" value="original_cataloging">
  <?php require __DIR__ . '/requester_auth.php'; ?>

  <?php if (!$requester_verified): ?>
    <div class="alert alert-info">Verify your email address to unlock the rest of this form.</div>
  <?php endif; ?>

  <?php if ($requester_verified): ?>
    <div class="section-card mb-4">
      <div class="section-title mb-3">Cataloging Request</div>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="oc_title_subtitle" class="form-label">Title and subtitle</label>
          <input type="text" class="form-control" id="oc_title_subtitle" name="oc_title_subtitle" value="<?= h($oc_title_subtitle) ?>" required>
        </div>
        <div class="col-md-6">
          <label for="oc_material_type" class="form-label">Material Type</label>
          <select class="form-select" id="oc_material_type" name="oc_material_type" required>
            <option value="" <?= $oc_material_type === '' ? 'selected' : '' ?>>Select material type</option>
            <option value="Book" <?= $oc_material_type === 'Book' ? 'selected' : '' ?>>Book</option>
            <option value="Audiobook" <?= $oc_material_type === 'Audiobook' ? 'selected' : '' ?>>Audiobook</option>
            <option value="Music CD" <?= $oc_material_type === 'Music CD' ? 'selected' : '' ?>>Music CD</option>
            <option value="Video" <?= $oc_material_type === 'Video' ? 'selected' : '' ?>>Video</option>
            <option value="Video game" <?= $oc_material_type === 'Video game' ? 'selected' : '' ?>>Video game</option>
            <option value="Realia" <?= $oc_material_type === 'Realia' ? 'selected' : '' ?>>Realia</option>
            <option value="Other" <?= $oc_material_type === 'Other' ? 'selected' : '' ?>>Other</option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="oc_genre_category" class="form-label">Genre or Category</label>
          <select class="form-select" id="oc_genre_category" name="oc_genre_category" required>
            <option value="" <?= $oc_genre_category === '' ? 'selected' : '' ?>>Select genre or category</option>
            <option value="Fiction" <?= $oc_genre_category === 'Fiction' ? 'selected' : '' ?>>Fiction</option>
            <option value="Nonfiction" <?= $oc_genre_category === 'Nonfiction' ? 'selected' : '' ?>>Nonfiction</option>
            <option value="Poetry" <?= $oc_genre_category === 'Poetry' ? 'selected' : '' ?>>Poetry</option>
            <option value="Biography" <?= $oc_genre_category === 'Biography' ? 'selected' : '' ?>>Biography</option>
            <option value="Other" <?= $oc_genre_category === 'Other' ? 'selected' : '' ?>>Other</option>
            <option value="Not applicable" <?= $oc_genre_category === 'Not applicable' ? 'selected' : '' ?>>Not applicable</option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="oc_format" class="form-label">Format (optional)</label>
          <select class="form-select" id="oc_format" name="oc_format">
            <option value="" <?= $oc_format === '' ? 'selected' : '' ?>>Select format</option>
            <option value="Large Print" <?= $oc_format === 'Large Print' ? 'selected' : '' ?>>Large Print</option>
            <option value="Regular Print" <?= $oc_format === 'Regular Print' ? 'selected' : '' ?>>Regular Print</option>
            <option value="Unabridged" <?= $oc_format === 'Unabridged' ? 'selected' : '' ?>>Unabridged</option>
            <option value="Abridged" <?= $oc_format === 'Abridged' ? 'selected' : '' ?>>Abridged</option>
            <option value="DVD" <?= $oc_format === 'DVD' ? 'selected' : '' ?>>DVD</option>
            <option value="Blu-ray" <?= $oc_format === 'Blu-ray' ? 'selected' : '' ?>>Blu-ray</option>
            <option value="4K UHD" <?= $oc_format === '4K UHD' ? 'selected' : '' ?>>4K UHD</option>
            <option value="Nintendo Switch" <?= $oc_format === 'Nintendo Switch' ? 'selected' : '' ?>>Nintendo Switch</option>
            <option value="PlayStation 4" <?= $oc_format === 'PlayStation 4' ? 'selected' : '' ?>>PlayStation 4</option>
            <option value="PlayStation 5" <?= $oc_format === 'PlayStation 5' ? 'selected' : '' ?>>PlayStation 5</option>
            <option value="Xbox One" <?= $oc_format === 'Xbox One' ? 'selected' : '' ?>>Xbox One</option>
            <option value="Xbox Series X" <?= $oc_format === 'Xbox Series X' ? 'selected' : '' ?>>Xbox Series X</option>
            <option value="Other (please specify in additional comments below)" <?= $oc_format === 'Other (please specify in additional comments below)' ? 'selected' : '' ?>>Other (please specify in additional comments below)</option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="oc_additional_format_info" class="form-label">Additional format information (optional)</label>
          <select class="form-select" id="oc_additional_format_info" name="oc_additional_format_info">
            <option value="" <?= $oc_additional_format_info === '' ? 'selected' : '' ?>>Select additional format info</option>
            <option value="VOX book" <?= $oc_additional_format_info === 'VOX book' ? 'selected' : '' ?>>VOX book</option>
            <option value="Playaway" <?= $oc_additional_format_info === 'Playaway' ? 'selected' : '' ?>>Playaway</option>
            <option value="Other (please specify in additional comments below)" <?= $oc_additional_format_info === 'Other (please specify in additional comments below)' ? 'selected' : '' ?>>Other (please specify in additional comments below)</option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="oc_author" class="form-label">Author (optional)</label>
          <input type="text" class="form-control" id="oc_author" name="oc_author" value="<?= h($oc_author) ?>">
        </div>
        <div class="col-md-6">
          <label for="oc_publisher_manufacturer" class="form-label">Publisher or Manufacturer (optional)</label>
          <input type="text" class="form-control" id="oc_publisher_manufacturer" name="oc_publisher_manufacturer" value="<?= h($oc_publisher_manufacturer) ?>">
        </div>
        <div class="col-md-6">
          <label for="oc_year_details" class="form-label">Year details (optional)</label>
          <input type="text" class="form-control" id="oc_year_details" name="oc_year_details" value="<?= h($oc_year_details) ?>">
        </div>
        <div class="col-md-6">
          <label for="oc_need_by_date" class="form-label">Record need-by date (optional)</label>
          <input type="date" class="form-control" id="oc_need_by_date" name="oc_need_by_date" value="<?= h($oc_need_by_date) ?>">
        </div>
        <div class="col-12">
          <label for="oc_physical_description" class="form-label">Physical Description</label>
          <textarea class="form-control" id="oc_physical_description" name="oc_physical_description" rows="2" required><?= h($oc_physical_description) ?></textarea>
        </div>
        <div class="col-12">
          <label for="oc_summary" class="form-label">Summary</label>
          <textarea class="form-control" id="oc_summary" name="oc_summary" rows="2" required><?= h($oc_summary) ?></textarea>
        </div>
        <div class="col-12">
          <label for="oc_additional_material_details" class="form-label">Additional material type details (optional)</label>
          <textarea class="form-control" id="oc_additional_material_details" name="oc_additional_material_details" rows="2"><?= h($oc_additional_material_details) ?></textarea>
        </div>
        <div class="col-12">
          <label for="oc_additional_comments" class="form-label">Additional comments, contents, playlist, illustrator, editor, ratings, etc (optional)</label>
          <textarea class="form-control" id="oc_additional_comments" name="oc_additional_comments" rows="2"><?= h($oc_additional_comments) ?></textarea>
        </div>
        <div class="col-md-6">
          <label for="oc_isbn_upc" class="form-label">ISBN or UPC (optional)</label>
          <input type="text" class="form-control" id="oc_isbn_upc" name="oc_isbn_upc" value="<?= h($oc_isbn_upc) ?>">
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
    </div>
  <?php endif; ?>
</form>
