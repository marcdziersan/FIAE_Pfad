const list = document.querySelector('#list');
const form = document.querySelector('#form');
const title = document.querySelector('#title');
async function loadItems(){
  const res = await fetch('/api/items');
  const items = await res.json();
  list.innerHTML = items.map(item => `<li>${item.title}</li>`).join('');
}
form.addEventListener('submit', async event => {
  event.preventDefault();
  await fetch('/api/items', {method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({title:title.value.trim()})});
  title.value = '';
  await loadItems();
});
loadItems();
