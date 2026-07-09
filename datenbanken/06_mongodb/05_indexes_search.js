// Aufgabe 05: Indizes und einfache Suche

use('fiae_mongodb');

db.kunden.createIndex({ email: 1 }, { unique: true });
db.kunden.createIndex({ ort: 1 });
db.auftraege.createIndex({ status: 1, kunde: 1 });

print('Index-Liste Kunden:');
printjson(db.kunden.getIndexes());

print('Offene Aufträge AGVS:');
printjson(db.auftraege.find({ kunde: 'AGVS GmbH', status: { $in: ['neu', 'in_bearbeitung'] } }).toArray());
