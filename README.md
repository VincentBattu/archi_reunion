# Archi n-tiers

## Comment installer le projet ?

- Cloner le repository accesible ```https://github.com/VincentBattu/archi_reunion```
- Installer les dépendances grâce à composer (il doit être installer sur le système, sé référer [ici](https://getcomposer.org/) si ce n'est pas les cas) : ```composer install```
- Créer la base de données : ```php bin/console doctrine:database:create```
- Mettre à jour le schéma : ```php bin/consoe doctrine:schema:update --force```

## Comment lancer l'application ?

- Soit avec le serveur interne de PHP (recommandé en dev) : ```php bin/console server:run```. Un serveur web est alors accessible sur localhost:8000
- Avec un serveur Apache/Nginx :
   * Soit sans redirection, auquel cas il faut se rendre sur l'url ```localhost://folder_name/web/app_dev.php```
   * Soit en programment la redirection au nouveau du serveur pour tout rediriger vers ```web/app.php```. L'application est alors accessible sur ```localhost```