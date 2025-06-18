# 🚀 OCR-P15 : Refactorisez le code d'un site pour l'optimiser

## Description
Ce projet est un site web dédié à la photographie de paysages, permettant à Ina Zaoui de partager ses œuvres et de promouvoir de jeunes photographes. L'application permet aux utilisateurs de découvrir des photos du monde entier et d'en savoir plus sur les voyages de l'artiste."

## Prérequis
- PHP >= 8.0
- Composer
- Symfony CLI
- Postgres SQL


## Outils de Développement
- PHPStan pour l'analyse statique
- Rector pour la modernisation du code
- PHPUnit pour les tests
- Symfony Profiler pour le débogage

## Structure du Projet
- `src/` : Code source de l'application
- `templates/` : Templates Twig
- `tests/` : Tests unitaires et fonctionnels
- `config/` : Configuration de l'application
- `public/` : Fichiers publics (assets, uploads)
- `migrations/` : Migrations de la base de données

# Installation

## 📥 1. Cloner le projet
Clonez le dépôt sur votre machine locale :
```bash
git clone https://github.com/LucasSch1/OCR-P15.git
cd OCR-P15
```
## ⚙️ 2. Installer les dépendances
Exécutez la commande suivante pour installer les dépendances PHP :
```bash
composer install
```
Attendez la fin du téléchargement et de l’installation des ressources.

## 🛠 3. Configurer la base de données
Modifiez le fichier **.env** pour **renseigner vos identifiants de connexion à la base de données.**

Voici la configuration attendue :
```bash
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/ina_zaoui?serverVersion=16&charset=utf8"
```
**⚠️ Remplacez app et !ChangeMe! par votre identifiant et votre mot de passe réel si nécessaire ainsi que la version de votre base de données.**

## 🏗 4. Créer et appliquer la base de données
➤ Créer la base de données :
```bash
php bin/console doctrine:database:create
```
➤ Appliquer la migration à la base de données :
```bash
php bin/console doctrine:migrations:migrate
```
**Confirmez en tapant yes si demandé.**

➤ Créer une migration (**si celle présente ne fonctionne pas**) :
```bash
php bin/console doctrine:migrations:diff
```


## 🔄 5. Créer la base de données de test et exécuter les migrations :
```bash
php bin/console doctrine:database:create --env=test
php bin/console doctrine:migrations:migrate --env=test
```


## ✅ 6. Vérifier la synchronisation du schéma
Assurez-vous que la base de données est bien en phase avec les entités :
```bash
php bin/console doctrine:schema:validate
```
Si tout est correct, vous devriez voir :

**Mapping   OK**

**Database  OK**

Les messages doivent s'afficher en vert ✅.

## 🗄 7. Ajouter des données de test
Chargez les fixtures (données de test) dans la base de données :
```bash
php bin/console doctrine:fixtures:load
```
Chargez les fixtures (données de test) dans la base de données de test :
```bash
php bin/console doctrine:fixtures:load --env=test
```

**Confirmez en tapant yes si demandé.**

# Usage

## 🚀 Lancer le serveur web
Démarrez le serveur Symfony en arrière-plan :
```bash
symfony serve -d
```
Cliquez ensuite sur le **lien affiché dans la console pour accéder au projet.**


## 🧪 Tests
Pour exécuter les tests :
```bash
php bin/phpunit
```
Note : Assurez-vous d'avoir configuré la base de données de test et chargé les fixtures avant d'exécuter les tests.

## 🔑 Connexion

Pour se connecter avec le compte Administrateur, il faut utiliser les identifiants suivants :

- Identifiant : `ina@zaoui.com`
- Mot de passe : `password`


Pour se connecter avec le compte Invité, il faut utiliser les identifiants suivants :

- Identifiant : `invite+1@exemple.com`
- Mot de passe : `password`
