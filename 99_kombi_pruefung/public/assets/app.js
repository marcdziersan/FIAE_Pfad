const api = 'api.php';
const message = document.querySelector('#message');

function escapeHtml(value) {
  return String(value).replace(/[&<>'"]/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#039;','"':'&quot;'}[char]));
}

async function request(action, payload = null) {
  const options = payload ? {method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(payload)} : {};
  const response = await fetch(`${api}?action=${action}`, options);
  const data = await response.json();
  if (!response.ok) throw new Error(data.error || 'Unbekannter Fehler');
  return data;
}

async function loadAll() {
  const data = await request('all');
  document.querySelector('#contacts').innerHTML = data.contacts.map(c => `<li><strong>${escapeHtml(c.name)}</strong><br>${escapeHtml(c.email)} · ${escapeHtml(c.phone)}</li>`).join('') || '<li>Keine Kontakte.</li>';
  document.querySelector('#notes').innerHTML = data.notes.map(n => `<li><strong>${escapeHtml(n.title)}</strong><br>${escapeHtml(n.text)}</li>`).join('') || '<li>Keine Notizen.</li>';
  document.querySelector('#orders').innerHTML = data.orders.map(o => `<tr><td>${escapeHtml(o.customer)}</td><td>${escapeHtml(o.title)}</td><td>${Number(o.gross).toFixed(2)} €</td><td class="ok">${escapeHtml(o.status)}</td></tr>`).join('') || '<tr><td colspan="4">Keine Aufträge.</td></tr>';
}

function bindForm(selector, action) {
  document.querySelector(selector).addEventListener('submit', async event => {
    event.preventDefault();
    const payload = Object.fromEntries(new FormData(event.currentTarget));
    try {
      await request(action, payload);
      event.currentTarget.reset();
      message.textContent = 'Gespeichert.';
      await loadAll();
    } catch (error) {
      message.textContent = error.message;
    }
  });
}

bindForm('#contactForm', 'addContact');
bindForm('#noteForm', 'addNote');
bindForm('#orderForm', 'addOrder');
document.querySelector('#refresh').addEventListener('click', loadAll);
loadAll();
