// Aufgabe 02: Update und Delete

use('fiae_mongodb');

// UPDATE: Status ändern
db.auftraege.updateOne(
  { titel: 'CSV Export' },
  { $set: { status: 'in_bearbeitung', aktualisiertAm: new Date() } }
);

// UPDATE: Feld ergänzen
db.kunden.updateMany(
  {},
  { $set: { aktiv: true } }
);

// DELETE: Beispiel-Dokument entfernen
db.auftraege.deleteMany({ status: 'storniert' });

printjson(db.auftraege.find().toArray());
