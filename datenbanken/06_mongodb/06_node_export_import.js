// Aufgabe 06: Export/Import-Idee mit Node.js
// Voraussetzung bei echter Ausführung: npm install mongodb

const { MongoClient } = require('mongodb');
const fs = require('fs/promises');

const uri = 'mongodb://127.0.0.1:27017';
const dbName = 'fiae_mongodb';

async function main() {
  const client = new MongoClient(uri);
  await client.connect();
  const db = client.db(dbName);

  const kunden = await db.collection('kunden').find().toArray();
  const auftraege = await db.collection('auftraege').find().toArray();

  await fs.writeFile('mongodb_export.json', JSON.stringify({ kunden, auftraege }, null, 2), 'utf8');
  console.log(`Exportiert: ${kunden.length} Kunden, ${auftraege.length} Aufträge`);

  await client.close();
}

main().catch((error) => {
  console.error(error);
  process.exitCode = 1;
});
