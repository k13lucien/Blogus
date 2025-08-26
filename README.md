Blogus - Laravel Docker Setup

Ce projet utilise Docker pour simplifier le développement Laravel avec MySQL, sans avoir à installer PHP, Composer ou MySQL localement.

Prérequis

Docker

Docker Compose

Démarrage rapide

Cloner le projet

git clone <ton-repo-url>
cd Blogus


Démarrer les conteneurs et builder l’image

docker-compose up -d --build


Le conteneur app démarre Laravel avec php artisan serve

Le conteneur db démarre MySQL

Vérifier que les conteneurs tournent

docker ps


blogus_app → Laravel server

blogus_db → MySQL

Accéder à l’application

Ouvre ton navigateur sur :
http://localhost:8000

Gestion de la base de données

Exécuter les migrations et seeders

docker-compose exec app php artisan migrate:fresh --seed


Se connecter à MySQL depuis le conteneur Laravel

docker-compose exec app bash
mysql -h db -u blogus -p
# mot de passe : blogus

Développement Frontend

Si tu as du JS/CSS :

docker-compose exec app npm install
docker-compose exec app npm run build

Commandes utiles

Redémarrer les conteneurs :

docker-compose restart


Arrêter les conteneurs :

docker-compose down


Exécuter Artisan depuis Docker :

docker-compose exec app php artisan <commande>


Installer une nouvelle dépendance Composer :

docker-compose exec app composer require <package>

Configuration .env pour Laravel
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=blogus
DB_USERNAME=blogus
DB_PASSWORD=blogus

Notes

Laravel est servi via php artisan serve sur le port 8000

MySQL est exposé sur le port 3306 (optionnel si tu veux te connecter avec un client externe)

Les données MySQL sont persistées dans le volume Docker dbdata