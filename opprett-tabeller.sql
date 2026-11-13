-- PRG120V obligatorisk oppgave 1. Kjør i din valgte database i phpMyAdmin.
-- Oppgavens CREATE TABLE-setninger.
CREATE TABLE oblig1_klasse (
    klassekode CHAR(5) NOT NULL,
    klassenavn VARCHAR(50) NOT NULL,
    studiumkode VARCHAR(50) NOT NULL,
    PRIMARY KEY (klassekode)
);

CREATE TABLE oblig1_student (
    brukernavn CHAR(7) NOT NULL,
    fornavn VARCHAR(50) NOT NULL,
    etternavn VARCHAR(50) NOT NULL,
    klassekode CHAR(5) NOT NULL,
    PRIMARY KEY (brukernavn),
    FOREIGN KEY (klassekode) REFERENCES oblig1_klasse (klassekode)
);
