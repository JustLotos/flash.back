COMPOSE=docker-compose
PHP=$(COMPOSE) exec php
CONSOLE=$(PHP) bin/console
COMPOSER=$(PHP) composer

up:
	@${COMPOSE} up -d

down:
	@${COMPOSE} down

clear:
	@${CONSOLE} cache:clear

crud:
	@${CONSOLE} make:crud


#DATABASE
	#DEV
create_db:
	@${CONSOLE} doctrine:database:create

drop_db:
	@${CONSOLE} doctrine:database:drop --force

migration:
	@${CONSOLE} make:migration

migrate:
	@${CONSOLE} doctrine:migrations:migrate

migration_diff:
	@${CONSOLE} doctrine:migrations:diff

fixtload:
	@${CONSOLE} doctrine:fixtures:load

	#TEST
create_db_test:
	@${CONSOLE} doctrine:database:create --env=test
drop_db_test:
	@${CONSOLE} doctrine:database:drop --force --env=test
migrate_test:
	@${CONSOLE} doctrine:migrations:migrate --env=test
fixtload_test:
	@${CONSOLE} doctrine:fixtures:load --env=test


routes:
	@${CONSOLE} debug:router
encore_dev:
	@${COMPOSE} run node yarn encore dev --watch

encore_prod:
	@${COMPOSE} run node yarn encore production

phpunit:
	@${PHP} bin/phpunit

dump_user:
	@${CONSOLE} doctrine:query:sql "select * from billing_user"

dump_course:
	@${CONSOLE} doctrine:query:sql "select * from course"

dump_transaction:
	@${CONSOLE} doctrine:query:sql "select * from transaction"