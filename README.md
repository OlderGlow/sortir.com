# Création du projet sortir.com pour ENI Ecole Informatique
# Début du projet : 10/08/2020

_Développé par :_
- PELLE Dylan
- WAFLART Pierre
- PICQUET Julien

_Langages utilisés :_
- PhP & Symfony
- HTML/TwiG
- CSS & Bootstrap
- Javascript (+jQuery)
- ORM Doctrine

_Versions utilisées :_
- PhP 7.3.*
- Symfony 4.4.* (LTS)
- Bootstrap 4.5
- Composer 1.10

# Lancement du projet :

_Commandes :_

`composer install`

`symfony serve`

# Fonctionnalités OK :

- Login/Logout
- Gestion des rôles
- Pagination
- Redirect to /connexion lorsque un anonyme arrive sur /
- Partie administration pour villes, campus et participants
- Date et nom sur accueil
- Responsive (Mobile + Tablette)

# @todo :

-Rajouter table Etat avec relation OnetoMany
- Ajax (Edit, Delete, Filter...)
- Gestion des sorties
- FileUploader photo (+ à afficher dans le header)
- Filtres et recherche
- Mot de passe oublié