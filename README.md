# symfony3402-AcmeAssociation
========================

Ce projet est basé sur la version 3.4 LTS de symfony

Contenu
--------------

But du projet:

Créer un site vitrine pour un nightclub fictif

Gestion des assets:

j'ai utilisé bootstrap 4 et webpack encore pour les assets

Fonctionnalités:

1/ j'ai mis en place une authentification avec encryptage des mots de passe, ainsi qu'une gestion des autorisations en fonction des rôles affectés à chacun utilisateurs (l'admin a accès à toutes les fonctionnalitées d'édition, modification, suppression, et création sur le site)

2/ j'ai mis en place un CRUD complet afin de de créer, éditer, voir, et supprimer les événements 

3/ l'administrateur du site a accès aux messages envoyés via le formulaire de contact qui sont sauvegardés en base de donnée

4/l'administrateur peut affecter le role ADMIN à un utilisateur basique

5/ j'ai mis en place un système d'upload de fichiers(image accessible dans la partie administration du site)

6/ j'ai en place l'envoi d'email avec swiftmailer

7/ j'ai mis en place un formulaire de contact permettant aux utilisateurs non enregistrés d'envoyer un message staff , l'utilisateur recoit un email html l'informant que son message à été sauvegarder en base de donn

