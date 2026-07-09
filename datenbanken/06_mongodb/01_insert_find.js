// Aufgabe 01: Dokumente einfügen und lesen
// Ausführung: mongosh 01_insert_find.js

use('fiae_mongodb');

db.kunden.drop();
db.auftraege.drop();

db.kunden.insertMany([
  { name: 'AGVS GmbH', email: 'kontakt@agvs.example', ort: 'Lünen' },
  { name: 'Polaris Nova', email: 'info@polaris.example', ort: 'Dortmund' },
  { name: 'Marbyte Lernsysteme', email: 'lernen@marbyte.example', ort: 'Bochum' }
]);

db.auftraege.insertMany([
  { kunde: 'AGVS GmbH', titel: 'Kanban Board', netto: 1200, status: 'in_bearbeitung' },
  { kunde: 'AGVS GmbH', titel: 'CSV Export', netto: 320, status: 'neu' },
  { kunde: 'Polaris Nova', titel: 'Landingpage', netto: 850, status: 'fertig' }
]);

print('Kunden in Lünen:');
printjson(db.kunden.find({ ort: 'Lünen' }).toArray());
