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
