-- Valgfritt: kjør én gang etter at tabellene er opprettet.
-- Testdataene som vises i oppgaveteksten.
INSERT INTO oblig1_klasse (klassekode, klassenavn, studiumkode) VALUES
('IT1', 'IT og ledelse 1. år', 'ITLED'),
('IT2', 'IT og ledelse 2. år', 'ITLED'),
('IT3', 'IT og ledelse 3. år', 'ITLED');

INSERT INTO oblig1_student (brukernavn, fornavn, etternavn, klassekode) VALUES
('gb', 'Geir', 'Bjarvin', 'IT1'),
('mrj', 'Marius R.', 'Johannessen', 'IT1'),
('tb', 'Tove', 'Bøe', 'IT2');
