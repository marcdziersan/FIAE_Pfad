const nameInput = document.querySelector('#name');
const message = document.querySelector('#message');
document.querySelector('#greet').addEventListener('click', () => {
  const name = nameInput.value.trim();
  message.textContent = name ? `Hallo ${name}. DOM-Manipulation funktioniert.` : 'Bitte Namen eingeben.';
});
document.querySelector('#toggle').addEventListener('click', () => document.body.classList.toggle('dark'));
