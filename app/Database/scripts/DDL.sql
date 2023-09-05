

create database if not exists autoecole;

use autoecole;

create table if not exists categorie(
  id int auto_increment not null primary key, -- pk
  libelle varchar(20) unique,
  prix int,
  nombre_seances_pratiques int
);

create table if not exists candidat(
  id int not null auto_increment primary key, -- pk
  nom varchar(255),
  prenom varchar(255),
  cin varchar(12) unique,
  telephone varchar(20),
  categorie varchar(10) not null references categorie(libelle), -- fk
  avance int,
  date_inscription date
);

create table if not exists seance(
  id int auto_increment not null primary key, -- pk
  candidat int not null references candidat(id), -- fk
  date_seance date
);