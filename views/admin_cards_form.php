<?php $show_requester_notes = false; ?>
<h2 class="h4 mb-3">Library card &amp; keytag order</h2>
<form method="post" novalidate>
  <input type="hidden" name="form_type" value="admin_cards">
  <?php require __DIR__ . '/requester_auth.php'; ?>

  <?php if (!$requester_verified): ?>
    <div class="alert alert-info">Verify your email address to unlock the rest of this form.</div>
  <?php endif; ?>

  <?php if ($requester_verified): ?>
    <div class="section-card mb-4">
      <div class="section-title mb-3">Order quantities</div>
      <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
          <thead>
            <tr>
              <th>Card type</th>
              <th style="width: 180px;">Quantity</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Library cards</td>
              <td><input type="number" min="0" step="1" class="form-control" name="ac_library_cards" value="<?= h($ac_library_cards) ?>"></td>
            </tr>
            <tr>
              <td>Keytags</td>
              <td><input type="number" min="0" step="1" class="form-control" name="ac_keytags" value="<?= h($ac_keytags) ?>"></td>
            </tr>
            <tr>
              <td>Card / keytag combos</td>
              <td><input type="number" min="0" step="1" class="form-control" name="ac_card_keytag_combos" value="<?= h($ac_card_keytag_combos) ?>"></td>
            </tr>
            <tr>
              <td colspan="2"></td>
            </tr>
            <tr>
              <td>Booklet library cards</td>
              <td><input type="number" min="0" step="1" class="form-control" name="ac_booklet_library_cards" value="<?= h($ac_booklet_library_cards) ?>"></td>
            </tr>
            <tr>
              <td>Booklet keytags</td>
              <td><input type="number" min="0" step="1" class="form-control" name="ac_booklet_keytags" value="<?= h($ac_booklet_keytags) ?>"></td>
            </tr>
            <tr>
              <td>Booklet card / keytag combos</td>
              <td><input type="number" min="0" step="1" class="form-control" name="ac_booklet_card_keytag_combos" value="<?= h($ac_booklet_card_keytag_combos) ?>"></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="section-card mb-4">
      <div class="section-title mb-3">Additional comments</div>
      <textarea class="form-control" name="ac_additional_comments" id="ac_additional_comments" rows="4"><?= h($ac_additional_comments) ?></textarea>
    </div>

    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
    </div>
  <?php endif; ?>
</form>
