# MonProjet Resto

Application Laravel de gestion de cantine connectée sur abonnement pour micro-restaurants.

Le but du projet est simple:

- éviter le gaspillage alimentaire;
- faire gagner du temps au restaurateur;
- suivre les abonnements des clients;
- publier le plat du jour;
- bloquer les commandes à une heure limite;
- permettre à plusieurs restaurants d'utiliser la même plateforme.

## Ce qui a été mis en place

### 1. Base de données locale

L’environnement local utilise une base MySQL configurée via le fichier `.env`.

- connexion par défaut: `mysql`
- base locale dédiée au projet;
- paramètres à adapter selon votre machine ou votre outil local;
- ne pas publier les identifiants de connexion dans le dépôt.

### 2. Modèle multi-restaurant

J’ai ajouté les entités principales du projet:

- `User`
- `Restaurant`
- `Subscription`
- `DailyMenu`
- `Order`

Ces modèles permettent de gérer:

- le restaurant propriétaire;
- le code unique du restaurant;
- les abonnements clients;
- les menus du jour;
- les commandes et leur livraison.

### 3. Migrations de base

Les migrations créées couvrent:

- la table `users` avec un champ `role`;
- la table `restaurants`;
- la table `subscriptions`;
- la table `daily_menus`;
- la table `orders`.

### 4. Contrôleurs métiers

J’ai créé les contrôleurs de base pour le flux principal:

- `AuthController`
- `RestaurantController`
- `SubscriptionController`
- `DailyMenuController`
- `OrderController`

Ils servent à:

- inscrire un restaurant;
- inscrire un client;
- se connecter et se déconnecter;
- créer et mettre à jour un restaurant;
- enregistrer et renouveler un abonnement;
- publier le menu du jour;
- passer une commande;
- marquer une commande comme livrée;
- calculer un résumé des commandes du jour.

### 5. Séparation des accès

Un middleware `role` a été ajouté pour séparer les accès:

- `restaurant`
- `client`

Cela prépare la base pour sécuriser les écrans et les actions selon le profil connecté.

### 6. Accueil du projet

La page d’accueil Laravel par défaut a été remplacée par une landing page adaptée au produit.

### 7. Espace développeur

Un tableau de bord interne est disponible pour les comptes avec le rôle `developer`.

- accès protégé par le middleware de rôle;
- statistiques globales sur les utilisateurs, restaurants, abonnements, menus et commandes;
- vues récentes des restaurants et des commandes;
- espace réservé aux besoins techniques et de supervision.

## Architecture du projet

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── DailyMenuController.php
│   │   ├── OrderController.php
│   │   ├── RestaurantController.php
│   │   └── SubscriptionController.php
│   └── Middleware/
│       └── CheckRole.php
└── Models/
    ├── DailyMenu.php
    ├── Order.php
    ├── Restaurant.php
    ├── Subscription.php
    └── User.php

database/
└── migrations/
    ├── 0001_01_01_000000_create_users_table.php
    ├── 2026_05_26_000001_create_restaurants_table.php
    ├── 2026_05_26_000002_create_subscriptions_table.php
    ├── 2026_05_26_000003_create_daily_menus_table.php
    └── 2026_05_26_000004_create_orders_table.php
```

## Fonctionnement métier

### Abonnement

Le client s’abonne à un restaurant pour une durée donnée.

- la date de début est enregistrée;
- la date de fin est calculée automatiquement;
- si l’abonnement est expiré, l’accès peut être bloqué.

### Menu du jour

Le restaurant publie le menu du jour le matin.

- le menu possède une date;
- il possède une heure limite de commande;
- après cette heure, les commandes peuvent être fermées.

### Commande

Le client abonné passe sa commande avant l’heure limite.

- la commande est liée à un menu;
- le total est calculé automatiquement;
- le restaurant peut marquer la commande comme livrée.

### Multi-restaurant

Chaque restaurant a:

- son propre profil;
- son propre code unique;
- ses propres menus;
- ses propres abonnements;
- ses propres commandes.

## Routes principales

### Authentification

- `POST /auth/restaurant/register`
- `POST /auth/client/register`
- `POST /auth/login`
- `POST /auth/logout`

### Restaurant

- `GET /restaurant/profile`
- `PUT /restaurants/{restaurant}`

### Abonnements

- `POST /subscriptions`
- `POST /subscriptions/{subscription}/renew`
- `GET /restaurants/{restaurant}/subscriptions/{user}`

### Menus

- `GET /restaurants/{restaurant}/menus`
- `GET /restaurants/{restaurant}/menus/today`
- `POST /restaurants/{restaurant}/menus`

### Commandes

- `POST /orders`
- `POST /orders/{order}/delivered`
- `GET /restaurants/{restaurant}/orders/summary`

## Installation locale

### 1. Installer les dépendances

```bash
composer install
npm install
```

### 2. Configurer l’environnement

Vérifie le fichier `.env` et renseigne tes paramètres locaux:

```env
DB_CONNECTION=...
DB_HOST=...
DB_PORT=...
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...
```

### 3. Créer la base MySQL

Crée une base vide dans MySQL puis adapte les variables du `.env` en conséquence.

### 4. Générer la clé d’application

```bash
php artisan key:generate
```

### 5. Lancer les migrations

```bash
php artisan migrate
```

### 6. Démarrer le projet

```bash
php artisan serve
npm run dev
```

## Vérification

Les tests de base passent déjà:

```bash
php artisan test
```

## Étapes suivantes recommandées

- créer un dashboard restaurant;
- créer un dashboard client;
- ajouter les policies pour bloquer les accès non autorisés;
- ajouter des seeders de démonstration;
- ajouter la logique de notification avant 10h30.

## Résumé rapide

Ce projet est maintenant structuré comme une vraie base SaaS pour micro-restaurants, avec une logique métier claire, une base MySQL et un démarrage propre pour continuer le développement.