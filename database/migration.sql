-- sqlite
-- https://www.sqlitetutorial.net/sqlite-autoincrement/
-- https://www.sqlite.org/datatype3.html

CREATE TABLE depoimentos (
  id INTEGER PRIMARY KEY,
  nome TEXT NOT NULL,
  mensagem TEXT NOT NULL,
  data TEXT NOT NULL
);

CREATE TABLE usuarios (
  id INTEGER PRIMARY KEY,
  nome TEXT NOT NULL,
  email TEXT NOT NULL UNIQUE,
  senha TEXT NOT NULL
 );
 
 -- senha 12345678
 INSERT INTO usuarios (nome, email, senha)
 VALUES ('Administrador Teste', 'teste@admin.com', '$2y$10$g9P8eL00K8z7uAbFNgYkSewJ7H8oHJzTuTJhY5MRRawegHblUzC0u');