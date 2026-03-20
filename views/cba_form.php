<?php $show_requester_notes = false; ?>
<h2 class="h4 mb-3">Request a CBA purchase</h2>
<form method="post" novalidate>
  <input type="hidden" name="form_type" value="cba">
  <?php require __DIR__ . '/requester_auth.php'; ?>

  <?php if (!$requester_verified): ?>
    <div class="alert alert-info">Verify your email address to unlock the rest of this form.</div>
  <?php endif; ?>

  <?php if ($requester_verified): ?>
    <div class="section-card mb-4">
      <div class="section-title mb-3">Request Details</div>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="cba_author" class="form-label">Author (optional)</label>
          <input type="text" class="form-control" id="cba_author" name="cba_author" value="<?= h($cba_author) ?>">
        </div>
        <div class="col-md-6">
          <label for="cba_title" class="form-label">Title</label>
          <input type="text" class="form-control" id="cba_title" name="cba_title" value="<?= h($cba_title) ?>" required>
        </div>
        <div class="col-md-6">
          <label for="cba_publisher" class="form-label">Publisher (optional)</label>
          <input type="text" class="form-control" id="cba_publisher" name="cba_publisher" value="<?= h($cba_publisher) ?>">
        </div>
        <div class="col-md-3">
          <label for="cba_year" class="form-label">Year (optional)</label>
          <input type="text" class="form-control" id="cba_year" name="cba_year" value="<?= h($cba_year) ?>">
        </div>
        <div class="col-md-3">
          <label for="cba_isbn" class="form-label">ISBN (optional)</label>
          <input type="text" class="form-control" id="cba_isbn" name="cba_isbn" value="<?= h($cba_isbn) ?>">
        </div>
        <div class="col-md-6">
          <label for="cba_subject_topic" class="form-label">Subject or Topic (optional)</label>
          <textarea class="form-control" id="cba_subject_topic" name="cba_subject_topic" rows="2"><?= h($cba_subject_topic) ?></textarea>
        </div>
        <div class="col-md-6">
          <label for="cba_citation_source" class="form-label">Citation Source (optional)</label>
          <textarea class="form-control" id="cba_citation_source" name="cba_citation_source" rows="2"><?= h($cba_citation_source) ?></textarea>
        </div>
        <div class="col-md-6">
          <label for="cba_notes_comments" class="form-label">Notes or Comments (optional)</label>
          <textarea class="form-control" id="cba_notes_comments" name="cba_notes_comments" rows="2"><?= h($cba_notes_comments) ?></textarea>
        </div>
        <div class="col-md-6">
          <label for="cba_format" class="form-label">Format (optional)</label>
          <select class="form-select" id="cba_format" name="cba_format">
            <option value="" <?= $cba_format === '' ? 'selected' : '' ?>>Select format</option>
            <option value="Book" <?= $cba_format === 'Book' ? 'selected' : '' ?>>Book</option>
            <option value="Large Print" <?= $cba_format === 'Large Print' ? 'selected' : '' ?>>Large Print</option>
            <option value="Audiobook-Cassette" <?= $cba_format === 'Audiobook-Cassette' ? 'selected' : '' ?>>Audiobook-Cassette</option>
            <option value="Audiobook-CD" <?= $cba_format === 'Audiobook-CD' ? 'selected' : '' ?>>Audiobook-CD</option>
            <option value="Video-DVD" <?= $cba_format === 'Video-DVD' ? 'selected' : '' ?>>Video-DVD</option>
            <option value="Video-Bluray" <?= $cba_format === 'Video-Bluray' ? 'selected' : '' ?>>Video-Bluray</option>
            <option value="OverDrive eBook" <?= $cba_format === 'OverDrive eBook' ? 'selected' : '' ?>>OverDrive eBook</option>
            <option value="OverDrive Audiobook" <?= $cba_format === 'OverDrive Audiobook' ? 'selected' : '' ?>>OverDrive Audiobook</option>
          </select>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
    </div>
  <?php endif; ?>
</form>
