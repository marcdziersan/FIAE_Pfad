-- Firebird-Schema. In einer leeren Lern-Datenbank ausführen.

CREATE TABLE kunden (
    id INTEGER NOT NULL,
    name VARCHAR(160) NOT NULL,
    email VARCHAR(190) NOT NULL,
    ort VARCHAR(120) NOT NULL,
    erstellt_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_kunden PRIMARY KEY (id),
    CONSTRAINT uq_kunden_email UNIQUE (email)
);

CREATE TABLE auftraege (
    id INTEGER NOT NULL,
    kunde_id INTEGER NOT NULL,
    titel VARCHAR(180) NOT NULL,
    netto NUMERIC(10,2) NOT NULL,
    status VARCHAR(30) DEFAULT 'neu' NOT NULL,
    erstellt_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_auftraege PRIMARY KEY (id),
    CONSTRAINT fk_auftraege_kunden FOREIGN KEY (kunde_id) REFERENCES kunden(id)
);
