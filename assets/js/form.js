const evergreenYes = document.getElementById('evergreen_yes');
const evergreenNo = document.getElementById('evergreen_no');
const evergreenFields = document.querySelectorAll('.evergreen-fields');

function toggleEvergreenFields() {
  const show = evergreenYes.checked;
  evergreenFields.forEach((field) => {
    field.style.display = show ? 'block' : 'none';
  });
}

if (evergreenYes && evergreenNo) {
  evergreenYes.addEventListener('change', toggleEvergreenFields);
  evergreenNo.addEventListener('change', toggleEvergreenFields);
  toggleEvergreenFields();
}
