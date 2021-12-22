-- sqlite
-- https://www.sqlitetutorial.net/sqlite-autoincrement/
-- https://www.sqlite.org/datatype3.html

CREATE TABLE depoimentos (
  id INTEGER PRIMARY KEY,
  nome TEXT NOT NULL,
  mensagem TEXT NOT NULL,
  data TEXT NOT NULL
);