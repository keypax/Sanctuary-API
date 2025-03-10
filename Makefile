build:
	docker-compose build

start:
	docker-compose up -d

composer-install:
	docker-compose exec php composer install

stop:
	docker-compose down

run-tests:
	docker-compose exec php php bin/phpunit

cache-clear:
	docker-compose exec php php bin/console cache:clear

create-db:
	docker-compose exec php php bin/console doctrine:database:drop --if-exists -f
	docker-compose exec php php bin/console doctrine:database:create
	docker-compose exec php php bin/console doctrine:schema:create

create-schema:
	docker-compose exec -T database_api pg_dump -U postgres -h database -d sanctuary --schema-only --no-owner --no-privileges --table=animal --table=animal_breed --table=animal_photo --table=animal_species --table=enclosure > schema.sql
	docker-compose exec -T database_api sh -c "psql -U postgres -d sanctuary" < schema.sql

create-subscription:
	docker-compose exec database_api sh -c "PGPASSWORD=pass psql -U postgres -h database_api -d sanctuary -c \"CREATE SUBSCRIPTION sanctuary_subscription_api CONNECTION 'host=database port=5432 dbname=sanctuary user=postgres password=pass' PUBLICATION sanctuary_publication_api WITH (copy_data = true);\""

drop-subscription:
	docker-compose exec database_api sh -c "PGPASSWORD=pass psql -U postgres -h database_api -d sanctuary -c \"DROP SUBSCRIPTION sanctuary_subscription_api;\""