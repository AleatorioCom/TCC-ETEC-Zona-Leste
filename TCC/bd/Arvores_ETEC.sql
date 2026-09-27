CREATE DATABASE TCC;
USE TCC;

CREATE TABLE Administrador (
    id_adm INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE Usuario (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE solicitacao (
    id_solicitacao INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    solicitacao VARCHAR(500) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE genero(
  id_genero INT PRIMARY KEY AUTO_INCREMENT,
  genero VARCHAR(100) NOT NULL
);

CREATE TABLE familia (
    id_familia INT PRIMARY KEY AUTO_INCREMENT,
    nome_familia VARCHAR(100) NOT NULL
);

CREATE TABLE flora (
    id_flora INT PRIMARY KEY AUTO_INCREMENT,
    id_adm INT NOT NULL,
    id_familia INT NOT NULL,
    id_genero INT NOT NULL,
    quantidade INT,
    alt_media FLOAT,
    nome_cien VARCHAR(50) NOT NULL,
    nome_popu VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_adm) REFERENCES Administrador(id_adm),
    FOREIGN KEY (id_familia) REFERENCES familia(id_familia),
    FOREIGN KEY (id_genero) REFERENCES genero(id_genero)
);

CREATE TABLE estado (
    id_estado INT PRIMARY KEY AUTO_INCREMENT,
    estado VARCHAR(20) NOT NULL
);

CREATE TABLE relatorio (
    id_relatorio INT PRIMARY KEY AUTO_INCREMENT,
    id_flora INT NOT NULL,
    id_estado INT NOT NULL,
    hora_relatorio DATETIME,
    altura FLOAT,
    relatorio VARCHAR(5000) NOT NULL,
    FOREIGN KEY (id_flora) REFERENCES flora(id_flora),
    FOREIGN KEY (id_estado) REFERENCES estado(id_estado)
);

CREATE TABLE descricao (
    id_flora INT PRIMARY KEY,
    descricao VARCHAR(10000) NOT NULL,
    FOREIGN KEY (id_flora) REFERENCES flora(id_flora)
);

INSERT INTO Administrador (email, senha) 
VALUES ('admin@etec.sp.gov.br', '123456');

INSERT INTO Usuario (email, senha) 
VALUES ('aluno@etec.sp.gov.br', '123456');