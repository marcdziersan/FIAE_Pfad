const operations = {
  '+': (a, b) => a + b,
  '-': (a, b) => a - b,
  '*': (a, b) => a * b,
  '/': (a, b) => b === 0 ? null : a / b
};
document.querySelector('#calc').addEventListener('submit', event => {
  event.preventDefault();
  const a = Number(document.querySelector('#a').value);
  const b = Number(document.querySelector('#b').value);
  const op = document.querySelector('#op').value;
  const value = operations[op](a, b);
  document.querySelector('#result').textContent = value === null ? 'Division durch 0 ist nicht erlaubt.' : String(value);
});
