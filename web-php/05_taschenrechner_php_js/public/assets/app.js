const a = document.querySelector('#a');
const b = document.querySelector('#b');
const op = document.querySelector('#op');
const preview = document.querySelector('#preview');

function format(value) {
  return new Intl.NumberFormat('de-DE', { maximumFractionDigits: 2 }).format(value);
}

function updatePreview() {
  const x = Number(a.value);
  const y = Number(b.value);
  if (!Number.isFinite(x) || !Number.isFinite(y) || a.value === '' || b.value === '') {
    preview.textContent = 'Bitte zwei Zahlen eingeben.';
    return;
  }
  let result;
  if (op.value === '+') result = x + y;
  if (op.value === '-') result = x - y;
  if (op.value === '*') result = x * y;
  if (op.value === '/') {
    if (y === 0) {
      preview.textContent = 'Division durch 0 ist nicht möglich.';
      return;
    }
    result = x / y;
  }
  preview.textContent = `${format(x)} ${op.value} ${format(y)} = ${format(result)}`;
}

[a, b, op].forEach(el => el.addEventListener('input', updatePreview));
updatePreview();
