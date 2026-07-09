const key = 'fiae-js-notes';
const form = document.querySelector('#form');
const notesEl = document.querySelector('#notes');
const read = () => JSON.parse(localStorage.getItem(key) || '[]');
const write = notes => localStorage.setItem(key, JSON.stringify(notes));
function render(){
  notesEl.innerHTML = read().map(note => `<article><h2>${escapeHtml(note.title)}</h2><p>${escapeHtml(note.text)}</p><button data-id="${note.id}">Löschen</button></article>`).join('') || '<p>Noch keine Notizen.</p>';
}
function escapeHtml(value){ return value.replace(/[&<>'"]/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#039;','"':'&quot;'}[char])); }
form.addEventListener('submit', event => {
  event.preventDefault();
  const notes = read();
  notes.push({id: crypto.randomUUID(), title: form.title.value.trim(), text: form.text.value.trim()});
  write(notes); form.reset(); render();
});
notesEl.addEventListener('click', event => {
  if (!event.target.matches('button[data-id]')) return;
  write(read().filter(note => note.id !== event.target.dataset.id));
  render();
});
render();
