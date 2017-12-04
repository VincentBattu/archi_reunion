# Archi n-tiers

## Prérequis :

- Version 7 de PHP ou supérieure et PHP ajouté au PATH (pour windows)
- composer installé ou exécutable en local. Se référer [ici](https://getcomposer.org/download/) pour l'installation

## Comment installer le projet ?

- Cloner le repository ```git clone https://github.com/VincentBattu/archi_reunion.git```
- Se déplacer dans le dossier ```cd archi_reunion```
- Installer les dépendances grâce à composer : ```composer install```
- Créer la base de données : ```php bin/console doctrine:database:create```
- Mettre à jour le schéma : ```php bin/console doctrine:schema:update --force```
- Installer les assets : ```php bin/console assets:install```
## Comment lancer l'application ?

- Soit avec le serveur interne de PHP (recommandé car la plus simple) : ```php bin/console server:run```. Un serveur web est alors accessible sur localhost:8000
- Avec un serveur Apache/Nginx :
   * Soit sans redirection, auquel cas il faut se rendre sur l'url ```localhost:port//archi_reunion/web/app_dev.php``` pour l'application en développement (avec debug et logs verbeux) ou sur ```localhost:port//archi_reunion/web/app.php``` pour l'application en prod.
   * Soit en programment la redirection au niveau du serveur pour tout rediriger vers ```web/app.php``` pour une application en prod ou ```web/app_dev.php``` pour une application en dev.
    L'application est alors accessible sur ```localhost:port```