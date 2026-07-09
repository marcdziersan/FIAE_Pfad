const netto = [120, 350, 80];
const brutto = value => Math.round(value * 1.19 * 100) / 100;
const summe = netto.reduce((total, value) => total + value, 0);
const report = {
  positionenNetto: netto,
  summeNetto: summe,
  summeBrutto: brutto(summe),
  skills: ['const/let', 'Arrays', 'reduce', 'Arrow Functions', 'Objekte']
};
document.querySelector('#output').textContent = JSON.stringify(report, null, 2);
