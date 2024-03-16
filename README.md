# APP G5C - SoundInShape

Année 2023-2024
Lien vers le tutoriel vidéo : https://drive.google.com/file/d/1asxPbreGVFyFmQhoWIJHzJEhgW9Gh8LS/view?usp=sharing

# Lancer le projet

La base de données est créée à partir de `sql/app.sql`.
Les logins sont

-   identifiant : `root`
-   mot de passe : `root`

# Pour déployer la branche main

Créer la BDD comme décrit juste au-dessus en éxécutant le code SQL mentionné ci-dessus dans phpMyAdmin.
Il faudra une base de données `app`. Cette base contiendra la table `users`.

-   Cloner le repo : `git clone james https://github.com/Paoladanagarcia/SoundInShape` dans un espace de travail PHP (`htdocs`, `www`, etc...).
    Lancer le projet : `http://localhost/soundinshape/`;

# Serveur mail SMTP

Il ne sera pas bien configuré par défaut. Tant pis.

# Explication du code

Le projet implémente une architecture MVC avec un routeur intelligent.

Quelle que soit l'URL saisie par l'utilisateur, celui-ci va être redirigé vers index.php à la racine du projet.

Ici, on va d'abord générer notre tableau de correspondance `chemin d'accès => fichier à inclure`.

Le routeur regarde toutes les classes `Controller` présentes dans le dossier `controller`.

Ensuite, le routeur va mémoriser l'attribut `#[Route("chemin")]` et éventuellement `#Method("methode http")` pour les renseigner dans un grand tableau `$routes`.

Si l'utilisateur appelle le chemin `logout`, on détectera dans index.php quel `Controller` appeler ainsi que la méthode à invoquer (celle qui était décorée par `#Route("chemin")`).

Le code du controlleur est responsable de partie logique et de l'accès à la base de données.
Il se conclut par :

-   soit par `echo json_encode(...); return;` pour renvoyer une réponse (si la méthode est `POST`) ;
-   soit par `require_once view/nom_de_la_vue.php`.

La vue contient le code HTML responsable de l'affichage des pages.
