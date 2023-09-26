create database dbRDV;
use dbRDV;
create table Medecin(
CodeMedecin int primary key,
NomMedecin varchar(20),
TelMedecin varchar(10),
DateEmbauche date,
SpecialiteMedecin varchar(20)
);
create table Patient(
CodePatient int primary key,
NomPatient varchar(10),
AdressePatient varchar(30),
DateNaissance date,
SexePatient varchar(10)
);
create table RDV (
NumRDV int primary key,
DateRDV date,
HeureRDV time,
CodePatient int,
CodeMedecin int,
constraint fk1_rdv
 foreign key (CodePatient)
 references Patient (CodePatient)
 on delete cascade
 on update cascade,
 constraint fk2_rdv
 foreign key (CodeMedecin)
 references Medecin (CodeMedecin)
 on delete cascade
 on update cascade
);
create table Utilisateur (
login varchar(20),
nom varchar(10),
prénom varchar(10),
password varchar(20), 
droit varchar(6) check (droit='admin' or droit='user')
);
insert into Medecin values('1', 'Benbouzid', '0612345678', '2020-05-08', 'Ophtalement'),
						  ('2', 'Bachadini', '0687654321', '2016-05-08', 'Interne'),
                          ('3', 'Eloutmani', '0787612345', '2018-05-08', 'Gastrologue'),
                          ('4', 'shiekh', '0612345987', '2020-05-08', 'Kardiologue'),
                          ('5', 'elmenssouri', '0512873476', '2010-09-08', '0phtalement');
insert into Utilisateur values('Youssef1', 'Youssef', 'Lahbari', '123', 'admin'),
						  ('Adam2', 'Adam', 'Ailouli', '1234', 'user'),
                          ('Samy3', 'Samy', 'Rizki', '12345', 'user'),
                          ('Zineb4', 'Zineb', 'Loktiri', '123456', 'user'),
                          ('Hamza5', 'Hamza', 'Essaki', '1234567', 'user');
insert into Patient values('1', 'Zaher', 'Lot Xxxx', '2000-05-08', 'Homme'),
						  ('2', 'Ahmed', 'Lot Yyyy', '2001-05-08', 'Homme'),
                          ('3', 'Marwa', 'Lot Zzzz', '2002-05-08', 'Femme'),
                          ('4', 'Hind', 'Lot Aaaa', '2003-05-08', 'Femme'),
                          ('5', 'Mery', 'Lot Bbbb', '2004-05-08', 'Femme');
insert into RDV values    ('1', '2018-05-08', '12:00', '1', '5'),
						  ('2', '2019-06-09', '13:00', '2', '4'),
                          ('3', '2020-07-10', '14:00', '3', '3'),
                          ('4', '2021-08-11', '15:00', '5', '2'),
                          ('5', '2022-09-12', '16:00', '4', '1');