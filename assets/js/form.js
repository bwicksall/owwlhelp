function bindYesNoToggle(yesId, noId, selector) {
  const yesInput = document.getElementById(yesId);
  const noInput = document.getElementById(noId);
  const fields = document.querySelectorAll(selector);

  if (!yesInput || !noInput || fields.length === 0) {
    return;
  }

  const toggle = () => {
    const show = yesInput.checked;
    fields.forEach((field) => {
      field.style.display = show ? 'block' : 'none';
    });
  };

  yesInput.addEventListener('change', toggle);
  noInput.addEventListener('change', toggle);
  toggle();
}

bindYesNoToggle('new_evergreen_yes', 'new_evergreen_no', '.new-evergreen-fields');
bindYesNoToggle('mod_change_email_yes', 'mod_change_email_no', '.mod-email-fields');
bindYesNoToggle('mod_change_evergreen_yes', 'mod_change_evergreen_no', '.mod-evergreen-fields');
bindYesNoToggle('mod_change_ad_yes', 'mod_change_ad_no', '.mod-ad-fields');
bindYesNoToggle('del_forward_yes', 'del_forward_no', '.del-forward-fields');

function bindSelectToggle(selectId, selector, attributeName) {
  const select = document.getElementById(selectId);
  const fields = document.querySelectorAll(selector);
  if (!select || fields.length === 0) {
    return;
  }

  const toggle = () => {
    const selected = select.value;
    fields.forEach((field) => {
      const target = field.getAttribute(attributeName);
      field.style.display = target === selected ? 'block' : 'none';
    });
  };

  select.addEventListener('change', toggle);
  toggle();
}

bindSelectToggle('oc_material_type', '.oc-type-fields', 'data-oc-type');

function bindOriginalCatalogingRequired() {
  const materialType = document.getElementById('oc_material_type');
  if (!materialType) {
    return;
  }

  const requiredByType = {
    Book: [
      'oc_book_publication_info',
      'oc_book_copyright',
      'oc_book_physical_description',
      'oc_book_intended_audience',
      'oc_book_format',
      'oc_book_summary',
    ],
    Audiobook: [
      'oc_audiobook_abridged_unabridged',
      'oc_audiobook_format',
      'oc_audiobook_physical_description',
      'oc_audiobook_publication_info',
      'oc_audiobook_copyright_phonogram',
      'oc_audiobook_intended_audience',
      'oc_audiobook_summary',
    ],
    'Musical recording': [
      'oc_music_publication_info',
      'oc_music_physical_description',
      'oc_music_copyright_phonogram',
      'oc_music_form',
    ],
    'Video recording': [
      'oc_video_format',
      'oc_video_publication_info',
      'oc_video_physical_description',
      'oc_video_form_of_work',
      'oc_video_summary',
    ],
    'Video game': [
      'oc_game_platform',
      'oc_game_publication_info',
      'oc_game_physical_description',
      'oc_game_summary',
    ],
    Realia: [
      'oc_realia_year_manufactured',
      'oc_realia_who_made',
      'oc_realia_contents',
      'oc_realia_container_size',
    ],
  };

  const managedIds = Object.values(requiredByType).flat();

  const update = () => {
    managedIds.forEach((id) => {
      const el = document.getElementById(id);
      if (el) {
        el.required = false;
      }
    });

    const selected = materialType.value;
    (requiredByType[selected] || []).forEach((id) => {
      const el = document.getElementById(id);
      if (el) {
        el.required = true;
      }
    });
  };

  materialType.addEventListener('change', update);
  update();
}

bindOriginalCatalogingRequired();
