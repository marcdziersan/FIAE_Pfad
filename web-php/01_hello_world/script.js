const button = document.querySelector('#helloButton');
const message = document.querySelector('#message');

button.addEventListener('click', () => {
  const now = new Date().toLocaleString('de-DE');
  message.textContent = `JavaScript läuft. Zeitpunkt: ${now}`;
});
