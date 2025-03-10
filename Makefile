include .env

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
	docker-compose exec -T $(DB_HOST) pg_dump -U $(PUBLISHER_DB_USER) -h $(PUBLISHER_DB_HOST) -p $(PUBLISHER_DB_PORT) -d $(PUBLISHER_DB_NAME) --schema-only --no-owner --no-privileges --table=animal --table=animal_breed --table=animal_photo --table=animal_species --table=enclosure > schema.sql
	docker-compose exec -T $(DB_HOST) sh -c "psql -U $(PUBLISHER_DB_USER) -h $(PUBLISHER_DB_HOST) -p $(PUBLISHER_DB_PORT) -d $(PUBLISHER_DB_NAME)" < schema.sql

create-subscription:
	docker-compose exec $(DB_HOST) sh -c "PGPASSWORD=$(PUBLISHER_DB_PASSWORD) psql -U $(PUBLISHER_DB_USER) -h $(DB_HOST) -p $(POSTGRES_PORT) -d $(PUBLISHER_DB_NAME) -c \"CREATE SUBSCRIPTION sanctuary_subscription_api CONNECTION 'host=$(PUBLISHER_DB_HOST) port=$(PUBLISHER_DB_PORT) dbname=$(PUBLISHER_DB_NAME) user=$(PUBLISHER_DB_USER) password=$(PUBLISHER_DB_PASSWORD)' PUBLICATION sanctuary_publication_api WITH (copy_data = true);\""

drop-subscription:
	docker-compose exec $(DB_HOST) sh -c "PGPASSWORD=$(PUBLISHER_DB_PASSWORD) psql -U $(PUBLISHER_DB_USER) -h $(DB_HOST) -p $(POSTGRES_PORT) -d $(PUBLISHER_DB_NAME) -c \"DROP SUBSCRIPTION sanctuary_subscription_api;\""