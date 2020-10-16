COMPOSE=docker-compose
PHP=$(COMPOSE) exec php
CONSOLE=$(PHP) bin/console
COMPOSER=$(PHP) composer

#DOCKER-COMPOSE
docker-up:
	@${COMPOSE} up -d

docker-down:
	@${COMPOSE} down --remove-orphans

docker-pull:
	@${COMPOSE} pull

docker-build:
	@${COMPOSE} build

up: docker-up v-dev
init: docker-down docker-pull docker-build docker-up composer-update yarn-install v-dev
serv-up: docker-down docker-up

#COMPOSER
composer-update:
	@${COMPOSER} update
composer-install:
	@${COMPOSER} install

#DATABASE
	#DEV
create_db:
	@${CONSOLE} doctrine:database:create

drop_db:
	@${CONSOLE} doctrine:database:drop --force

migration:
	@${CONSOLE} make:migration --no-interaction

migrate:
	@${CONSOLE} doctrine:migrations:migrate --no-interaction

midiff:
	@${CONSOLE} doctrine:migrations:diff --no-interaction

fixtload:
	@${CONSOLE} doctrine:fixtures:load --no-interaction
full_reset_db: drop_db create_db midiff migrate fixtload
	#TEST
create_db_test:
	@${CONSOLE} doctrine:database:create --env=test --no-interaction
drop_db_test:
	@${CONSOLE} doctrine:database:drop --force --env=test --no-interaction
migrate_test:
	@${CONSOLE} doctrine:migrations:migrate --env=test --no-interaction
fixtload_test:
	@${CONSOLE} doctrine:fixtures:load --env=test --no-interaction

full_reset_db_test: drop_db_test create_db_test migrate_test fixtload_test


routes:
	@${CONSOLE} debug:router
yarn-install:
	@${COMPOSE} run node yarn install
	@${COMPOSE} run node yarn add @babel/compat-data
v-dev:
	@${COMPOSE} run node yarn encore dev --watch
v-prod:
	@${COMPOSE} run node yarn encore production


phpunit:
	@${PHP} bin/phpunit ./tests/Unit
