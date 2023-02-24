# challenge-stack

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Create .env file based on .env.example, if you are developing and/or you are in local remove the line `SERVER_NAME=""`
3. Run `docker compose build --pull --no-cache` to build fresh images
4. Run `docker compose up` (the logs will be displayed in the current shell) or Run `docker compose up -d` to run in background
5. Check variable in .env : `DATABASE_URL="postgresql://symfony:ChangeMe@database:5432/app?serverVersion=13&charset=utf8"`
6. Run `docker compose exec php npm install` to install node_modules
7.  Run `docker compose exec php npm run dev` or `docker compose exec php npm run watch` to build assets
8. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334) and you are done !
9. Run `docker compose down --remove-orphans` to stop the Docker containers.
10. Run `docker compose logs -f` to display current logs, `docker compose logs -f [CONTAINER_NAME]` to display specific container's current logs

## Documentation 
#### Gestion de base de données
##### Commandes de création des fichiers entity/repository et d'ajout de champs
`docker compose exec php bin/console make:entity`

Documentation sur les relations entre les entités [https://symfony.com/doc/current/doctrine/associations.html](https://symfony.com/doc/current/doctrine/associations.html)

##### Mise à jour de la base de données via migration
Generation d'une migration 

`docker compose exec php bin/console make:migration`

Jouer les migrations 

`docker compose exec php bin/console doctrine:migration:migrate`

`docker compose exec php bin/console d:m:m`

##### Mise à jour de la base de données via update de schema sans migration
Voir les requètes interprétées (sans mise à jour de la DB)

`docker compose exec php bin/console doctrine:schema:update --dump-sql`

`docker compose exec php bin/console d:s:u --dump-sql`

Executer les requètes en DB

`docker compose exec php bin/console doctrine:schema:update --force`

`docker compose exec php bin/console d:s:u --force`

### Ajout de données via les DataFixtures

`docker compose exec php bin/console doctrine:fixtures:load`

### Architecture pour les fichiers uploadés

`data-files/` <br />
`├─ user-pictures/`<br />
`│  ├─ ID-image.jpg`<br />
`├─ media_list-pictures/`<br />
`│  ├─ ID-image.jpg`<br />
`├─ artist-pictures/`<br />
`│  ├─ ID-image.jpg`<br />
`├─ concert_hall-pictures/`<br />
`│  ├─ ID-image.jpg`<br />
`├─ event-pictures/`<br />
`│  ├─ ID-image.jpg`<br />
`├─ media-pictures/`<br />
`│  ├─ ID-image.jpg`<br />