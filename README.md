# Projet de Gestion des Transactions

Ce projet est une application web permettant de créer et de suivre des transactions via l'API FedaPay.

## Fonctionnalités

- Création d'une nouvelle transaction à partir d'un formulaire
- Validation des champs du formulaire
- Redirection vers la page de paiement FedaPay
- Récupération et affichage des détails de la transaction après le paiement

## Technologies Utilisées

- Laravel pour le backend
- Bootstrap pour l'interface utilisateur
- FedaPay API pour la gestion des transactions

## Installation

1. Clonez le dépôt : 

git clone https://github.com/votre-compte/projet-transactions-fedapay.git

2. Installez les dépendances avec Composer : 

composer install

3. Configurez les variables d'environnement dans le fichier `.env` :

FEADAY_API_KEY=votre_cle_api
FEADAY_ENVIRONMENT=production_or_test

4. Exécutez les migrations de la base de données si il y a lieu :

php artisan migrate

5. Lancez le serveur :
 
 php artisan serve

6. Accédez à l'application à l'adresse `http://127.0.0.1:8000`.

## Structure du Projet

Le projet est structuré de la manière suivante :
projet-transactions-fedapay/
├── app/
│   └── Http/
│       └── Controllers/
│           └── TransactionController.php
├── resources/
│   └── views/
│       ├── create_transaction.blade.php
│       └── callback_result.blade.php
├── routes/
│   └── web.php
├── .env
├── composer.json
└── README.md
- `TransactionController.php` : contrôleur gérant la logique de création de transaction et de récupération des résultats.
- `create_transaction.blade.php` : page contenant le formulaire de création de transaction.
- `callback_result.blade.php` : page affichant les informations relatives à la transaction créée après le paiement.
- `.env` : fichier de configuration de l'environnement, où vous devez définir vos clés API FedaPay.
- `web.php` : fichier de routes reliant les URLs aux méthodes du contrôleur.



## Licence

Ce projet est sous licence.
