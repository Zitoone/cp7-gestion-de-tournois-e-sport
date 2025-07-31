# CP 7 Evaluation PHP et PDO

## Projet: Application web de gestion de tournois e-sport

**Objectif**

Cette évaluation a pour vocation de valider les compétences du titre Développeur Web et Web Mobile
ayant pour intitulé :

Activité Type 2 - Développer la partie back-end d’une application web ou web mobile sécurisée
- Développer des composants d’accès aux données SQL et NoSQL
- Développer des composants métier côté serveur

**Description**

Ce projet a pour but d'évaluer votre capacité à développer des composants métier
côté serveur avec PHP et PDO. Vous devrez concevoir le coeur du système d’une
application web de gestion de tournois e-sport, sans vous préoccuper de l’interface
utilisateur.

**Critères d’évaluation**
✓ Respect des contraintes du projet
✓ Qualité, efficacité et compréhension des requêtes
✓ Clarté du code et de l’organisation
✓ Fréquence de commit et messages associés
✓ Pertinence de la présentation orale

**Contexte**
Vous êtes missionné(e) pour construire l'architecture backend d'une application dédiée à la gestion de
compétitions e-sport, un domaine en pleine expansion.
Cette plateforme permettra à des joueurs passionnés de s'inscrire, de créer ou de rejoindre des
équipes, et de participer à des tournois organisés autour de jeux vidéo populaires.
Les organisateurs pourront quant à eux publier des événements compétitifs, définir les règles des
tournois et gérer les inscriptions des équipes.
Enfin, les administrateurs du système auront une vue d'ensemble sur les utilisateurs, les compétitions
et les performances globales de la plateforme, leur permettant d'assurer le bon fonctionnement de
l'application, de modérer les contenus et d'analyser les statistiques de participation.
Le système devra donc gérer plusieurs rôles avec des droits différenciés, garantir l'intégrité des
données échangées, et permettre des opérations fiables sur les équipes, les utilisateurs et les
tournois.

### User stories 
Les user stories exposent les besoins fonctionnels auxquels le système doit répondre du point de vue
des utilisateurs finaux de la plateforme, même si vous ne devez pas développer d'interface graphique.
Elles servent à orienter la construction des composants métier du back-end de l'application en PHP, à
l'aide de PDO pour la communication avec la base de données.
En vous appuyant sur ces user stories, vous devrez proposer une structure relationnelle cohérente,
implémenter les traitements nécessaires pour gérer les données (inscriptions, connexions, créations,
modifications, suppressions), et assurer que les interactions entre le code PHP et la base soient
sécurisées, fonctionnelles et bien structurées.
Chaque user story correspond à une fonctionnalité essentielle que le système doit gérer, et vous
devrez être en mesure d'y répondre en codant des fonctions backend claires, testables et efficaces.

**US1 : Création de compte**

• En tant que nouveau participant, je veux pouvoir créer un compte avec email et mot de
passe, afin de pouvoir rejoindre des équipes et participer à la plateforme.

**US2 : Connexion**

• En tant qu’utilisateur enregistré, je veux pouvoir me connecter avec mon email et mot de
passe, afin d’accéder à mes fonctionnalités personnalisées.

**US3 : Déconnexion**

• En tant qu’utilisateur connecté, je veux pouvoir me déconnecter de mon compte, afin de
sécuriser mon accès.

**US4 : Modifier mon profil**

• En tant qu’utilisateur, je veux pouvoir modifier mes informations personnelles, afin de garder
mon profil à jour.

**US5 : Créer une équipe**

• En tant que joueur, je veux pouvoir créer ma propre équipe, afin de participer à des
compétitions avec mes coéquipiers.

**US6 : Rejoindre une équipe**

• En tant que joueur, je veux pouvoir rejoindre une équipe existante, afin de jouer en groupe.

**US7 : Gérer les membres de mon équipe**

• En tant que capitaine, je veux pouvoir ajouter ou retirer des joueurs de mon équipe, afin
d’organiser efficacement mes membres.

**US8 : Créer un tournoi**

• En tant qu’organisateur, je veux pouvoir créer un tournoi avec nom, jeu, date et règles, afin
d’organiser des compétitions.

**US9 : Modifier un tournoi**

• En tant qu’organisateur, je veux pouvoir modifier les détails d’un tournoi que j’ai créé, afin de
corriger ou mettre à jour les informations.

**US10 : Supprimer un tournoi**

• En tant qu’organisateur ou admin, je veux pouvoir supprimer un tournoi, afin de retirer un
événement annulé ou terminé.

**US11 : Inscrire une équipe à un tournoi**

• En tant que joueur/capitaine, je veux pouvoir inscrire mon équipe à un tournoi, afin de
participer officiellement.

**US12 : Lister les tournois ouverts**

• En tant que joueur, je veux voir tous les tournois ouverts à l’inscription, afin de choisir où
participer.

**US13 : Voir les équipes inscrites à un tournoi**

• En tant qu’organisateur, je veux voir la liste des équipes inscrites à mes tournois, afin de
suivre la participation.

**US14 : Supprimer une équipe (admin uniquement)**

• En tant qu’administrateur, je veux pouvoir supprimer une équipe, afin de gérer les cas de
non-respect des règles ou abus.

**US15 : Voir les statistiques de participation**

• En tant qu’administrateur, je veux voir le nombre d’équipes inscrites à chaque tournoi, afin
d’analyser la fréquentation.

**US16 : Gérer les rôles utilisateurs**

• En tant qu’administrateur, je veux attribuer ou modifier les rôles (joueur, capitaine,
organisateur, admin), afin de contrôler les permissions.

**US17 : Consulter le détail d’une équipe**

• En tant que joueur ou organisateur, je veux consulter la composition et les informations
d’une équipe, afin de mieux connaître mes adversaires ou coéquipiers.

**US18 : Consulter mes inscriptions à des tournois**

• En tant que joueur, je veux voir la liste des tournois auxquels mon équipe est inscrite, afin de
gérer mon calendrier.

### Lien repository GitHub
https://github.com/Zitoone/cp7-gestion-de-tournois-e-sport