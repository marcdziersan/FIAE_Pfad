SET TERM !! ;

CREATE OR ALTER PROCEDURE report_kundenumsatz
RETURNS (
    kunde VARCHAR(160),
    anzahl_auftraege INTEGER,
    netto_summe NUMERIC(10,2)
)
AS
BEGIN
  FOR
    SELECT
      k.name,
      COUNT(a.id),
      COALESCE(SUM(a.netto), 0)
    FROM kunden k
    LEFT JOIN auftraege a ON a.kunde_id = k.id
    GROUP BY k.name
    INTO :kunde, :anzahl_auftraege, :netto_summe
  DO
    SUSPEND;
END!!

SET TERM ; !!

SELECT * FROM report_kundenumsatz;
