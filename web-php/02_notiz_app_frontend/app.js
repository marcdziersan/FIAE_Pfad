const STORAGE_KEY = 'fiae_notes_frontend';
const form = document.querySelector('#noteForm');
const titleInput = document.querySelector('#title');
const contentInput = document.querySelector('#content');
const notesList = document.querySelector('#notesList');
const formMessage = document.querySelector('#formMessage');
const template = document.querySelector('#noteTemplate');

function loadNotes() {
  const raw = localStorage.getItem(STORAGE_KEY);
  return raw ? JSON.parse(raw) : [];
}

function saveNotes(notes) {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(notes));
}

function createNote(title, content) {
  return {
    id: crypto.randomUUID(),
    title,
    content,
    createdAt: new Date().toISOString(),
  };
}

function renderNotes() {
  const notes = loadNotes();
  notesList.innerHTML = '';

  if (notes.length === 0) {
    notesList.textContent = 'Noch keine Notizen vorhanden.';
    return;
  }

  for (const note of notes) {
    const node = template.content.cloneNode(true);
    node.querySelector('h3').textContent = note.title;
    node.querySelector('p').textContent = note.content;
    node.querySelector('small').textContent = new Date(note.createdAt).toLocaleString('de-DE');
    node.querySelector('.delete-button').addEventListener('click', () => deleteNote(note.id));
    notesList.appendChild(node);
  }
}

function deleteNote(id) {
  const notes = loadNotes().filter(note => note.id !== id);
  saveNotes(notes);
  renderNotes();
}

form.addEventListener('submit', (event) => {
  event.preventDefault();
  const title = titleInput.value.trim();
  const content = contentInput.value.trim();

  if (title.length < 3 || content.length < 3) {
    formMessage.textContent = 'Titel und Inhalt müssen mindestens 3 Zeichen haben.';
    return;
  }

  const notes = loadNotes();
  notes.unshift(createNote(title, content));
  saveNotes(notes);

  form.reset();
  formMessage.textContent = 'Notiz gespeichert.';
  renderNotes();
});

renderNotes();
