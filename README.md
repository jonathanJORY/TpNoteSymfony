Symfony Application Web Flopify
========================

## Membres
### Charpentier Maxym
### Jory Jonathan

------------
## Présentation

L'application web flopify est une application de présentation de Musique.
On peut voir une liste de différents albums et voir les musiques, les genres et les auteurs.

Requirements
------------

  * PHP
  * Symfony
  * and the [usual Symfony application requirements][2].

Installation
------------
 Installer symfony et composer.
 
 Se placer dans le répertoire racine et executer la commande composer update.
 
 Pour crée la base de données faire la commande suivante, (ici elle est déjà crée).
 Puis executer la commande symfony console doctrine:migrations:migrate pour la création de la BDD.
 
 Pour remplir la base de données il faut faire la commande suivante après avoir crée la BDD
  php bin/console doctrine:fixtures:load
  En cas d'erreur il faut la refaire jusqu'à ce que ca marche car l'api a parfois quelques soucis. 
  Si les erreurs persite supprime la BDD et la recrée puis réessayer.

 
Usage
-----

 Se placer dans le répertoire racine.
 Executer la commande symfony server:start

Fonctionnalités
-----

Une application web permettant de présenter des albums, des musiques, des genres et des auteurs.

* Système de login pour les utilisateurs.
* Mot de passe chiffré dans la BDD.
* CRUD sur les albums, musiques, auteurs, genres et utilisateur.
* Système d'inscription des utilisateurs.
* Affichage paginé des albums, détail au survol ou au click
* Intégration Boostrap5 ou autre lib de CSS
* Possibilité d'import de données (datafixture)
* Importer des albums d'une API (api spotify)
* Edition/Suppression/Update Albumss
* Edition/Suppression/Update Auteur
* Edition/Suppression/Update Musique
* Edition/Suppression/Update Genres

* Si on se place dans un album pour crée une musique l'album sera alors préremplie 
* Plus un jolie css pour accompagner les fonctionnalités

