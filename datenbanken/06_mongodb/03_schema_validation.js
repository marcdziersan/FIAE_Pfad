// Aufgabe 03: Schema-Validierung für eine Collection

use('fiae_mongodb');

db.createCollection('kontakte_validiert', {
  validator: {
    $jsonSchema: {
      bsonType: 'object',
      required: ['name', 'email', 'rolle'],
      properties: {
        name: { bsonType: 'string' },
        email: { bsonType: 'string' },
        rolle: { enum: ['kunde', 'lieferant', 'intern'] },
        aktiv: { bsonType: 'bool' }
      }
    }
  }
});

db.kontakte_validiert.insertOne({
  name: 'Demo Kontakt',
  email: 'demo@example.de',
  rolle: 'kunde',
  aktiv: true
});

printjson(db.kontakte_validiert.find().toArray());
