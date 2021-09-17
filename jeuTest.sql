use sortiedotcom;

INSERT INTO ville ( nom, code_postal) VALUES ('QUIMPER', 29000);
INSERT INTO ville ( nom, code_postal) VALUES ('NANTES', 44000);
INSERT INTO ville ( nom, code_postal) VALUES ('NIORT', 79000);
INSERT INTO ville ( nom, code_postal) VALUES ('RENNES', 35000);
INSERT INTO ville ( nom, code_postal) VALUES ('BREST', 29200);

INSERT INTO lieu ( ville_id, nom, rue, latitude, longitude) VALUES ( 1, 'Cathédrale', 'Avenue saint-corentin', 47.99582735849404, -4.1029801298755775);
INSERT INTO lieu ( ville_id, nom, rue, latitude, longitude) VALUES ( 1, 'Thépot', 'Avenue Yves-thépot', 47.987762772241425, -4.086145858986141);
INSERT INTO lieu ( ville_id, nom, rue, latitude, longitude) VALUES ( 2, 'Commerce', 'Place du commerce', 47.21336038141977, -1.558161857465151);
INSERT INTO lieu ( ville_id, nom, rue, latitude, longitude) VALUES ( 2, 'Atlantis', 'Centre commercial Saint-herblain', 47.225370273470226, -1.6320716899902612);
INSERT INTO lieu ( ville_id, nom, rue, latitude, longitude) VALUES ( 3, 'La fontaine', 'Place de la fontaine', 48.09365551327037, -1.643386459286408);
INSERT INTO lieu ( ville_id, nom, rue, latitude, longitude) VALUES ( 4, 'Rue de la soif', 'Centre ville', 48.1141313601665, -1.6813784770031472);
INSERT INTO lieu ( ville_id, nom, rue, latitude, longitude) VALUES ( 5, 'CHU morvan', 'Centre ville Brest', 48.39261463502303, -4.487352553545516);
INSERT INTO lieu ( ville_id, nom, rue, latitude, longitude) VALUES ( 2, 'Point Nemo', 'ya po', -48.875560, -123.392500);
INSERT INTO lieu ( ville_id, nom, rue, latitude, longitude) VALUES ( 1, 'Géant Casino', 'Route de benodet', 47.97446348581729, -4.095718620462796);
INSERT INTO lieu ( ville_id, nom, rue, latitude, longitude) VALUES ( 5, 'Stade Francis Le Blé', 'Rue de Quimper', 48.40289822164945, -4.461564410871301);

INSERT INTO site (nom) VALUES ( 'ENI NANTES');
INSERT INTO site (nom) VALUES ( 'ENI RENNES');
INSERT INTO site (nom) VALUES ( 'ENI NIORT');
INSERT INTO site (nom) VALUES ( 'ENI EN LIGNE');

INSERT INTO `participant` (`site_id`, `pseudo`, `roles`, `password`, `nom`, `prenom`, `telephone`, `administrateur`, `actif`, `email`, `id_photo`) VALUES
( 1, 'Rhomu', '[]', '$2y$13$/rNImdUc7XlKOfQyOkI2pumsOT25t4doSXnkyvF.u.JvRhedGNP8O', 'Romuald', 'Gagnon', '012345542', 0, 0, 'romuald@mail.fr', NULL),
( 2, 'Poulain', '[]', '$2y$13$GRkDz0Nio2bRwQP.hhLY9uq88ntc0yW6lBhwz7ZA4r70XppIOELwi', 'Tangi', 'Camus', '012345671', 0, 0, 'tangi@mail.fr', NULL),
( 1, 'TiKer','[]', '$2y$13$rkC2CVpFsFc80bvxK.jCPuJgRfRROjuDkeSlWCUWdgc1oBAHIRSMi', 'Thibaut', 'Kerouedan', '012345672', 0, 0, 'thibaut@mail.fr', NULL),
( 2, 'Maxouille', '[]', '$2y$13$bDuheRCn2atof8A7uDPVhuH8K//hbFdKRqy25MfyX9rawDK9BKGRy', 'Maxime', 'Reguenes', '012345673', 0, 0, 'max@mail.fr', NULL),
( 1, 'Junko', '[]', '$2y$13$Xyc3rQwS15p1DsYnwurQouL0RRuIG6SFGU1J7Dz8rVYixFArLW2Y.', 'Junko', 'Junko', '012345674', 0, 0, 'Junko@mail.fr', NULL),
( 2, 'Virginie', '[]', '$2y$13$C/Nj33ZwJVam7NLLuzjFMeuOPWhhRgfdVt4tGjd.aQHCjtrBTxJae', 'Virginie', 'Virginie', '012345675', 0, 0, 'Virginie@mail.fr', NULL),
( 1, 'Iris', '[]', '$2y$13$jv2eYFBo7Ke5oXz7A/huvuyjBOIajM1V9RcD3vRuILIA0r29pli6S', 'Iris', 'Iris', '012345676', 0, 0, 'Iris@mail.fr', NULL),
( 2, 'Danny', '[]', '$2y$13$b2x/4gcfbiITYv04/PhUr.4n5ZxJTB2I4mCP2bz8fW3jJZ/KWVKL2', 'Danny', 'Danny', '012345677', 0, 0, 'Danny@mail.fr', NULL),
( 1, 'Shary', '[]', '$2y$13$fduPG7gBak1lcETIXIZ1uuTqs1/TrK4cpM3YEnCr5UmbSx5510Nsq', 'Shary', 'Shary', '012345678', 0, 0, 'Shary@mail.fr', NULL),
( 2, 'Frances', '[]', '$2y$13$5/d5mqhgrWV4L.MZAKtGSuI.LTuydcq1xRtewJNL/9yi7gTaWPWMy', 'Frances', 'Frances', '012345679', 0, 0, 'Frances@mail.fr', NULL),
( 1, 'Chiaki', '[]', '$2y$13$CHhaSmBLv8KdXigveiIlOuLcik96fmtwnBR34nhxvjoz80KXl6/lu', 'Chiaki', 'Chiaki', '0123456710', 0, 0, 'Chiaki@mail.fr', NULL),
( 2, 'Ophelia', '[]', '$2y$13$MVK3OtnxjdDWAUEGvbQYGO9UvcFmGh.6y691q/514D/hO1ZxpwNHC', 'Ophelia', 'Ophelia', '0123456711', 0, 0, 'Ophelia@mail.fr', NULL),
( 1, 'Etsuko', '[]', '$2y$13$FLlaeP/uQP5Ja6Ty7LhQIuXNmrJCaAJwKzmfcpG2hUlw4uD5CFzLy', 'Etsuko', 'Etsuko', '0123456712', 0, 0, 'Etsuko@mail.fr', NULL),
( 2, 'Otto', '[]', '$2y$13$tbB86NktEvX8yHW/MJ0XyeDR40jgFlu3JQszihyiLKl9QYgedDuOC', 'Otto', 'Otto', '0123456713', 0, 0, 'Otto@mail.fr', NULL),
( 1, 'Nadine', '[]', '$2y$13$FJyE8eCBzTdoxcEZthykXOk0X999RNeNHwwE31OyLGN7JYEuMHU7.', 'Nadine', 'Nadine', '0123456714', 0, 0, 'Nadine@mail.fr', NULL),
( 2, 'Pablo', '[]', '$2y$13$o4TrZBGN60EpOA56y1bupOlDqdVb7fgvL4JaOAza0JJ3DStm7jdsu', 'Pablo', 'Pablo', '0123456715', 0, 0, 'Pablo@mail.fr', NULL),
( 1, 'Itoe', '[]', '$2y$13$nkI1gmbB0KTmyTLhfriiKumYmOSabQrqZLZoAh7JO96c07.hG1EJe', 'Itoe', 'Itoe', '0123456716', 0, 0, 'Itoe@mail.fr', NULL),
( 2, 'Chris', '[]', '$2y$13$jySFo3b/FJcI4OaTs2Y7yeNdbgyAPvIodrN85EOk1cSknvvA8da9m', 'Chris', 'Chris', '0123456717', 0, 0, 'Chris@mail.fr', NULL),
( 1, 'Harvey', '[]', '$2y$13$6QkUjxQhEm13BOM/giNKuebQw87ZMSdPraSKIi4op4DHu1lBrX1YG', 'Harvey', 'Harvey', '0123456718', 0, 0, 'Harvey@mail.fr', NULL),
( 2, 'Philippe', '[]', '$2y$13$DHWvg7B/ap8SowXVmWC5KeR8qQ0YKSNcgeB5qJx2U9f4e9NKV./uu', 'Philippe', 'Philippe', '0123456719', 0, 0, 'Philippe@mail.fr', NULL);

INSERT INTO sortie ( site_id, lieu_id, etat_id, organisateur_id, nom, date_heure_debut, duree, nb_inscription_max, infos_sortie, date_limite_inscription) VALUES (1, 1, 1, 2, 'Faire les magasins', '2021-12-24 13:17:17', 60, 15, 'Lacoste, Apple, Hollister', '2021-11-18 00:00:00');
INSERT INTO sortie ( site_id, lieu_id, etat_id, organisateur_id, nom, date_heure_debut, duree, nb_inscription_max, infos_sortie, date_limite_inscription) VALUES (1, 2, 2, 2, 'Faire les magasins', '2021-11-20 13:17:17', 20, 3, 'Dans des magasins', '2021-11-10 00:00:00');
INSERT INTO sortie ( site_id, lieu_id, etat_id, organisateur_id, nom, date_heure_debut, duree, nb_inscription_max, infos_sortie, date_limite_inscription) VALUES (2, 3, 2, 3, 'Aller courir', '2021-11-20 13:17:17', 70, 1, 'Longtemps', '2021-11-10 00:00:00');
INSERT INTO sortie ( site_id, lieu_id, etat_id, organisateur_id, nom, date_heure_debut, duree, nb_inscription_max, infos_sortie, date_limite_inscription) VALUES (2, 4, 2, 3, 'Faire des courses', '2021-11-20 13:17:17', 70, 20, NULL, '2021-09-12 00:00:00');
INSERT INTO sortie ( site_id, lieu_id, etat_id, organisateur_id, nom, date_heure_debut, duree, nb_inscription_max, infos_sortie, date_limite_inscription) VALUES (3, 5, 2, 4, 'Sortie en mer', '2021-09-13 13:17:17', 60000, 20, NULL, '2021-09-13 01:00:00');
INSERT INTO sortie ( site_id, lieu_id, etat_id, organisateur_id, nom, date_heure_debut, duree, nb_inscription_max, infos_sortie, date_limite_inscription) VALUES (4, 6, 2, 5, 'Sortie à la plage', '2021-09-13 13:17:17', 60, 25, NULL, '2021-09-13 01:00:00');
INSERT INTO sortie ( site_id, lieu_id, etat_id, organisateur_id, nom, date_heure_debut, duree, nb_inscription_max, infos_sortie, date_limite_inscription) VALUES (5, 7, 7, 5, 'Sortie dans les champs', '2021-09-14 13:17:17', 20, 45, NULL, '2021-09-13 01:00:00');
INSERT INTO sortie ( site_id, lieu_id, etat_id, organisateur_id, nom, date_heure_debut, duree, nb_inscription_max, infos_sortie, date_limite_inscription) VALUES (5, 7, 2, 3, 'Sortie à la campagne', '2021-09-15 13:17:17', 20, 45, NULL, '2021-09-14 01:00:00');
INSERT INTO sortie ( site_id, lieu_id, etat_id, organisateur_id, nom, date_heure_debut, duree, nb_inscription_max, infos_sortie, date_limite_inscription) VALUES (2, 8, 5, 2, 'Survie en radeau', '2021-09-12 13:17:17', 15000, 16, 'Teambuilding en radeau au milieu du pacifique', '2021-09-10 01:00:00');
INSERT INTO sortie ( site_id, lieu_id, etat_id, organisateur_id, nom, date_heure_debut, duree, nb_inscription_max, infos_sortie, date_limite_inscription) VALUES (2, 4, 2, 3, 'Sortie shopping', '2021-09-29 13:17:17', 180, 16, NULL, '2021-09-27 01:00:00');
INSERT INTO sortie ( site_id, lieu_id, etat_id, organisateur_id, nom, date_heure_debut, duree, nb_inscription_max, infos_sortie, date_limite_inscription) VALUES (1, 2, 2, 2, 'Taco Tuesday', '2021-09-21 13:17:17', 30, 16, 'Petit repas leger a base de tacos 3 viandes', '2021-09-18 01:00:00');
INSERT INTO sortie ( site_id, lieu_id, etat_id, organisateur_id, nom, date_heure_debut, duree, nb_inscription_max, infos_sortie, date_limite_inscription) VALUES (5, 10, 6, 5, 'Brest Paris', '2021-08-20 13:17:17', 120, 8, 'Match Brest Paris en Ligue 1 Uber Eats', '2021-08-10 01:00:00');


INSERT INTO `participant_sortie` (`participant_id`, `sortie_id`) VALUES
(4,1),(5,1),(4, 5),
(3,9),(4,9),(5,9),
(3,11),(4,11),(5,11),
(2,12),(3,12),(4,12);

INSERT INTO `annulation_sortie` (`id`, `sortie_id`, `libelle`) VALUES
(1, 2, 'Parce que'),
(2,1,'J''ai deja fait une autre sortie similaire.');

