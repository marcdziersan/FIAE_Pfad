document.querySelector('#load').addEventListener('click', async () => {
  const response = await fetch('data.json');
  const entries = await response.json();
  document.querySelector('#list').innerHTML = entries.map(entry => `<li><strong>${entry.title}</strong>: ${entry.text}</li>`).join('');
});
