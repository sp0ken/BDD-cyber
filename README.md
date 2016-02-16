Base de Données Urbicande
========================

Base de données utilisée par l'association Urbicande pour créer et développer ses GN.

Installation
------------

* Installer composer dans le répertoire racine du projet :
    `curl -sS https://getcomposer.org/installer | php`
* Mettre à jour les vendors
    `php composer.phar update`
* Optionnel, changer les prefixes des tables (ne pas oublier *vendor/gedmo/doctrine-extensions/lib/Gedmo/Loggable/Entity/LogEntry.php*)
* Modifier *app/config/parameters.yml* avec les valeurs adaptées (le supervisor_email est la personne qui recevra un mail pour chaque action des utilisateurs sur la base)
* Générer la table
    `php app/console doctrine:schema:create`
* Et voilà

