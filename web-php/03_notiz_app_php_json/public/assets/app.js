document.querySelectorAll('.delete-form').forEach((form) => {
  form.addEventListener('submit', (event) => {
    const confirmed = confirm('Diese Notiz wirklich löschen?');
    if (!confirmed) {
      event.preventDefault();
    }
  });
});
