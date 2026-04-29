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
          <label for="oc_title" class="form-label">Title</label>
          <input type="text" class="form-control" id="oc_title" name="oc_title" value="<?= h(post_value('oc_title')) ?>" required>
        </div>
        <div class="col-md-6">
          <label for="oc_isbn_upc" class="form-label">ISBN or UPC (optional)</label>
          <input type="text" class="form-control" id="oc_isbn_upc" name="oc_isbn_upc" value="<?= h(post_value('oc_isbn_upc')) ?>">
        </div>
        <div class="col-md-6">
          <label for="oc_need_by_date" class="form-label">Record need-by date</label>
          <input type="date" class="form-control" id="oc_need_by_date" name="oc_need_by_date" value="<?= h(post_value('oc_need_by_date')) ?>" required>
        </div>
        <div class="col-md-6">
          <label for="oc_material_type" class="form-label">Material type</label>
          <select class="form-select" id="oc_material_type" name="oc_material_type" required>
            <option value="" <?= post_value('oc_material_type') === '' ? 'selected' : '' ?>>Select material type</option>
            <option value="Book" <?= post_value('oc_material_type') === 'Book' ? 'selected' : '' ?>>Book</option>
            <option value="Audiobook" <?= post_value('oc_material_type') === 'Audiobook' ? 'selected' : '' ?>>Audiobook</option>
            <option value="Musical recording" <?= post_value('oc_material_type') === 'Musical recording' ? 'selected' : '' ?>>Musical recording</option>
            <option value="Video recording" <?= post_value('oc_material_type') === 'Video recording' ? 'selected' : '' ?>>Video recording</option>
            <option value="Video game" <?= post_value('oc_material_type') === 'Video game' ? 'selected' : '' ?>>Video game</option>
            <option value="Realia" <?= post_value('oc_material_type') === 'Realia' ? 'selected' : '' ?>>Realia</option>
          </select>
        </div>
      </div>
    </div>

    <div class="section-card mb-4 oc-type-fields" data-oc-type="Book">
      <div class="section-title mb-3">Book Details</div>
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label" for="oc_book_author">Author</label><input class="form-control" id="oc_book_author" name="oc_book_author" value="<?= h(post_value('oc_book_author')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_book_illustrator">Illustrator</label><input class="form-control" id="oc_book_illustrator" name="oc_book_illustrator" value="<?= h(post_value('oc_book_illustrator')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_book_editor">Editor</label><input class="form-control" id="oc_book_editor" name="oc_book_editor" value="<?= h(post_value('oc_book_editor')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_book_translator">Translator</label><input class="form-control" id="oc_book_translator" name="oc_book_translator" value="<?= h(post_value('oc_book_translator')) ?>"></div>
        <div class="col-12"><label class="form-label" for="oc_book_publication_info">Publication information</label><input class="form-control" id="oc_book_publication_info" name="oc_book_publication_info" value="<?= h(post_value('oc_book_publication_info')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_book_copyright">Copyright</label><input class="form-control" id="oc_book_copyright" name="oc_book_copyright" value="<?= h(post_value('oc_book_copyright')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_book_intended_audience">Intended audience</label><input class="form-control" id="oc_book_intended_audience" name="oc_book_intended_audience" value="<?= h(post_value('oc_book_intended_audience')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_book_format">Format</label><input class="form-control" id="oc_book_format" name="oc_book_format" value="<?= h(post_value('oc_book_format')) ?>"></div>
        <div class="col-12"><label class="form-label" for="oc_book_physical_description">Physical description</label><textarea class="form-control" id="oc_book_physical_description" name="oc_book_physical_description" rows="2"><?= h(post_value('oc_book_physical_description')) ?></textarea></div>
        <div class="col-12"><label class="form-label" for="oc_book_summary">Summary</label><textarea class="form-control" id="oc_book_summary" name="oc_book_summary" rows="2"><?= h(post_value('oc_book_summary')) ?></textarea></div>
        <div class="col-12"><label class="form-label" for="oc_book_additional_information">Additional information</label><textarea class="form-control" id="oc_book_additional_information" name="oc_book_additional_information" rows="2"><?= h(post_value('oc_book_additional_information')) ?></textarea></div>
      </div>
    </div>

    <div class="section-card mb-4 oc-type-fields" data-oc-type="Audiobook">
      <div class="section-title mb-3">Audiobook Details</div>
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label" for="oc_audiobook_author">Author</label><input class="form-control" id="oc_audiobook_author" name="oc_audiobook_author" value="<?= h(post_value('oc_audiobook_author')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_audiobook_abridged_unabridged">Abridged or Unabridged</label><input class="form-control" id="oc_audiobook_abridged_unabridged" name="oc_audiobook_abridged_unabridged" value="<?= h(post_value('oc_audiobook_abridged_unabridged')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_audiobook_format">Format</label><input class="form-control" id="oc_audiobook_format" name="oc_audiobook_format" value="<?= h(post_value('oc_audiobook_format')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_audiobook_physical_description">Physical description</label><input class="form-control" id="oc_audiobook_physical_description" name="oc_audiobook_physical_description" value="<?= h(post_value('oc_audiobook_physical_description')) ?>"></div>
        <div class="col-12"><label class="form-label" for="oc_audiobook_publication_info">Publication information</label><input class="form-control" id="oc_audiobook_publication_info" name="oc_audiobook_publication_info" value="<?= h(post_value('oc_audiobook_publication_info')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_audiobook_copyright_phonogram">Copyright or Phonogram date</label><input class="form-control" id="oc_audiobook_copyright_phonogram" name="oc_audiobook_copyright_phonogram" value="<?= h(post_value('oc_audiobook_copyright_phonogram')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_audiobook_intended_audience">Intended audience</label><input class="form-control" id="oc_audiobook_intended_audience" name="oc_audiobook_intended_audience" value="<?= h(post_value('oc_audiobook_intended_audience')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_audiobook_narrators">Narrator(s)</label><input class="form-control" id="oc_audiobook_narrators" name="oc_audiobook_narrators" value="<?= h(post_value('oc_audiobook_narrators')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_audiobook_playing_time">Playing time</label><input class="form-control" id="oc_audiobook_playing_time" name="oc_audiobook_playing_time" value="<?= h(post_value('oc_audiobook_playing_time')) ?>"></div>
        <div class="col-12"><label class="form-label" for="oc_audiobook_summary">Summary</label><textarea class="form-control" id="oc_audiobook_summary" name="oc_audiobook_summary" rows="2"><?= h(post_value('oc_audiobook_summary')) ?></textarea></div>
        <div class="col-12"><label class="form-label" for="oc_audiobook_additional_information">Additional information</label><textarea class="form-control" id="oc_audiobook_additional_information" name="oc_audiobook_additional_information" rows="2"><?= h(post_value('oc_audiobook_additional_information')) ?></textarea></div>
      </div>
    </div>

    <div class="section-card mb-4 oc-type-fields" data-oc-type="Musical recording">
      <div class="section-title mb-3">Musical Recording Details</div>
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label" for="oc_music_performers">Performer(s)</label><input class="form-control" id="oc_music_performers" name="oc_music_performers" value="<?= h(post_value('oc_music_performers')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_music_explicit_or_edited">Explicit or Edited version</label><input class="form-control" id="oc_music_explicit_or_edited" name="oc_music_explicit_or_edited" value="<?= h(post_value('oc_music_explicit_or_edited')) ?>"></div>
        <div class="col-12"><label class="form-label" for="oc_music_publication_info">Publication information</label><input class="form-control" id="oc_music_publication_info" name="oc_music_publication_info" value="<?= h(post_value('oc_music_publication_info')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_music_physical_description">Physical description</label><input class="form-control" id="oc_music_physical_description" name="oc_music_physical_description" value="<?= h(post_value('oc_music_physical_description')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_music_copyright_phonogram">Copyright or Phonogram date</label><input class="form-control" id="oc_music_copyright_phonogram" name="oc_music_copyright_phonogram" value="<?= h(post_value('oc_music_copyright_phonogram')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_music_playing_time">Playing time</label><input class="form-control" id="oc_music_playing_time" name="oc_music_playing_time" value="<?= h(post_value('oc_music_playing_time')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_music_form">Form of music</label><input class="form-control" id="oc_music_form" name="oc_music_form" value="<?= h(post_value('oc_music_form')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_music_intended_audience">Intended audience</label><input class="form-control" id="oc_music_intended_audience" name="oc_music_intended_audience" value="<?= h(post_value('oc_music_intended_audience')) ?>"></div>
        <div class="col-12"><label class="form-label" for="oc_music_playlist">Playlist</label><textarea class="form-control" id="oc_music_playlist" name="oc_music_playlist" rows="2"><?= h(post_value('oc_music_playlist')) ?></textarea></div>
      </div>
    </div>

    <div class="section-card mb-4 oc-type-fields" data-oc-type="Video recording">
      <div class="section-title mb-3">Video Recording Details</div>
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label" for="oc_video_format">Format</label><input class="form-control" id="oc_video_format" name="oc_video_format" value="<?= h(post_value('oc_video_format')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_video_publisher_number">Publisher number</label><input class="form-control" id="oc_video_publisher_number" name="oc_video_publisher_number" value="<?= h(post_value('oc_video_publisher_number')) ?>"></div>
        <div class="col-12"><label class="form-label" for="oc_video_publication_info">Publication information</label><input class="form-control" id="oc_video_publication_info" name="oc_video_publication_info" value="<?= h(post_value('oc_video_publication_info')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_video_copyright_date">Copyright date</label><input class="form-control" id="oc_video_copyright_date" name="oc_video_copyright_date" value="<?= h(post_value('oc_video_copyright_date')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_video_screen">Full screen or wide screen</label><input class="form-control" id="oc_video_screen" name="oc_video_screen" value="<?= h(post_value('oc_video_screen')) ?>"></div>
        <div class="col-12"><label class="form-label" for="oc_video_physical_description">Physical description</label><textarea class="form-control" id="oc_video_physical_description" name="oc_video_physical_description" rows="2"><?= h(post_value('oc_video_physical_description')) ?></textarea></div>
        <div class="col-12"><label class="form-label" for="oc_video_form_of_work">Form of work</label><input class="form-control" id="oc_video_form_of_work" name="oc_video_form_of_work" value="<?= h(post_value('oc_video_form_of_work')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_video_rating_reason">Rating and reason</label><input class="form-control" id="oc_video_rating_reason" name="oc_video_rating_reason" value="<?= h(post_value('oc_video_rating_reason')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_video_languages">Language(s) of dialogue and subtitles</label><input class="form-control" id="oc_video_languages" name="oc_video_languages" value="<?= h(post_value('oc_video_languages')) ?>"></div>
        <div class="col-12"><label class="form-label" for="oc_video_directors">Director(s)</label><input class="form-control" id="oc_video_directors" name="oc_video_directors" value="<?= h(post_value('oc_video_directors')) ?>"></div>
        <div class="col-12"><label class="form-label" for="oc_video_producers">Producer(s)</label><input class="form-control" id="oc_video_producers" name="oc_video_producers" value="<?= h(post_value('oc_video_producers')) ?>"></div>
        <div class="col-12"><label class="form-label" for="oc_video_actors">Actor(s)</label><input class="form-control" id="oc_video_actors" name="oc_video_actors" value="<?= h(post_value('oc_video_actors')) ?>"></div>
        <div class="col-12"><label class="form-label" for="oc_video_summary">Summary</label><textarea class="form-control" id="oc_video_summary" name="oc_video_summary" rows="2"><?= h(post_value('oc_video_summary')) ?></textarea></div>
        <div class="col-12"><label class="form-label" for="oc_video_additional_information">Additional information</label><textarea class="form-control" id="oc_video_additional_information" name="oc_video_additional_information" rows="2"><?= h(post_value('oc_video_additional_information')) ?></textarea></div>
      </div>
    </div>

    <div class="section-card mb-4 oc-type-fields" data-oc-type="Video game">
      <div class="section-title mb-3">Video Game Details</div>
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label" for="oc_game_platform">Gaming platform</label><input class="form-control" id="oc_game_platform" name="oc_game_platform" value="<?= h(post_value('oc_game_platform')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_game_publisher_number">Publisher number</label><input class="form-control" id="oc_game_publisher_number" name="oc_game_publisher_number" value="<?= h(post_value('oc_game_publisher_number')) ?>"></div>
        <div class="col-12"><label class="form-label" for="oc_game_publication_info">Publication information</label><input class="form-control" id="oc_game_publication_info" name="oc_game_publication_info" value="<?= h(post_value('oc_game_publication_info')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_game_copyright_date">Copyright date</label><input class="form-control" id="oc_game_copyright_date" name="oc_game_copyright_date" value="<?= h(post_value('oc_game_copyright_date')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_game_rating_age">Rating or recommended age level</label><input class="form-control" id="oc_game_rating_age" name="oc_game_rating_age" value="<?= h(post_value('oc_game_rating_age')) ?>"></div>
        <div class="col-12"><label class="form-label" for="oc_game_physical_description">Physical description</label><textarea class="form-control" id="oc_game_physical_description" name="oc_game_physical_description" rows="2"><?= h(post_value('oc_game_physical_description')) ?></textarea></div>
        <div class="col-12"><label class="form-label" for="oc_game_summary">Summary</label><textarea class="form-control" id="oc_game_summary" name="oc_game_summary" rows="2"><?= h(post_value('oc_game_summary')) ?></textarea></div>
      </div>
    </div>

    <div class="section-card mb-4 oc-type-fields" data-oc-type="Realia">
      <div class="section-title mb-3">Realia Details</div>
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label" for="oc_realia_year_manufactured">Year manufactured or assembled</label><input class="form-control" id="oc_realia_year_manufactured" name="oc_realia_year_manufactured" value="<?= h(post_value('oc_realia_year_manufactured')) ?>"></div>
        <div class="col-md-6"><label class="form-label" for="oc_realia_who_made">Who made this</label><input class="form-control" id="oc_realia_who_made" name="oc_realia_who_made" value="<?= h(post_value('oc_realia_who_made')) ?>"></div>
        <div class="col-12"><label class="form-label" for="oc_realia_manufacturer_information">Manufacturer information</label><input class="form-control" id="oc_realia_manufacturer_information" name="oc_realia_manufacturer_information" value="<?= h(post_value('oc_realia_manufacturer_information')) ?>"></div>
        <div class="col-12"><label class="form-label" for="oc_realia_contents">Contents</label><textarea class="form-control" id="oc_realia_contents" name="oc_realia_contents" rows="2"><?= h(post_value('oc_realia_contents')) ?></textarea></div>
        <div class="col-md-6"><label class="form-label" for="oc_realia_container_size">Size of container/box</label><input class="form-control" id="oc_realia_container_size" name="oc_realia_container_size" value="<?= h(post_value('oc_realia_container_size')) ?>"></div>
        <div class="col-12"><label class="form-label" for="oc_realia_contents_list">Contents list</label><textarea class="form-control" id="oc_realia_contents_list" name="oc_realia_contents_list" rows="2"><?= h(post_value('oc_realia_contents_list')) ?></textarea></div>
        <div class="col-12"><label class="form-label" for="oc_realia_associated_isbns_upcs">Associated ISBNs or UPCs</label><textarea class="form-control" id="oc_realia_associated_isbns_upcs" name="oc_realia_associated_isbns_upcs" rows="2"><?= h(post_value('oc_realia_associated_isbns_upcs')) ?></textarea></div>
      </div>
    </div>

    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
    </div>
  <?php endif; ?>
</form>
