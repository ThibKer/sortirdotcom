# sortirdotcom
projet symfony

#####INSTALLATION#####

----Pour récupérer le projet----
git clone https://github.com/ThibKer/sortirdotcom

----Avoir toutes les commandes dans le projet----
composer install

----Création de la base de donnée et de ces tables----
Récupérer le script SQL nommé "creationDatabase.sql" à la racine du projet et l'éxécuter dans phpMyAdmin ou autre application de gestion de base de données MySQL
Ce script créer la base, les tables et ajoute un utilisateur ainsi que le site de "ENI QUIMPER".

---Première connection au site----
Aller sur la racine du site et vous serez rediriger sur le login, il suffit de vous connecter avec "login : 'admin'" et "mot de passe : 'motDePasseAdmin'",
avec ce compte vous aurez accès à l'url du site avec un "/register" qui permettra de créer les différents compte du site qui permettront son utilisation.


#####TEST#####

----Ajout données de tests----
Récupérer le script SQL nommé "jeuTest.sql" à la racine du projet et l'éxécuter dans phpMyAdmin ou autre application de gestion de base de données MySQL
