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