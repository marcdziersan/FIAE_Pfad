// Aufgabe 04: Aggregation für Reports

use('fiae_mongodb');

const report = db.auftraege.aggregate([
  {
    $group: {
      _id: '$kunde',
      anzahl: { $sum: 1 },
      nettoSumme: { $sum: '$netto' },
      durchschnitt: { $avg: '$netto' }
    }
  },
  { $sort: { nettoSumme: -1 } }
]).toArray();

printjson(report);
