###> export environment variables ###
-include .env
export
###< export environment variables ###

###> variables ###
DOCKER_COMPOSE = USER_UID=$(shell id -u) USER_GID=$(shell id -g) docker-compose --env-file .env
NGINX = $(DOCKER_COMPOSE) run -T nginx
PHP_CLI = $(DOCKER_COMPOSE) exec -T php-cli
PHP_FPM = $(DOCKER_COMPOSE) exec -T php-fpm
POSTGRES = $(DOCKER_COMPOSE) run -T postgres
COMPOSER = $(PHP_CLI) composer
ARTISAN = $(PHP_CLI) php artisan
PHPSTAN = $(PHP_CLI) vendor/bin/phpstan --memory-limit=512M
ECS = $(PHP_CLI) vendor/bin/ecs
CODECEPTION = $(PHP_CLI) ./vendor/bin/codecept
###< variables ###

###> composite commands ###
init: docker-init app-init
docker-init: down-with-remove-volumes build up
app-init: composer-install artisan-config-clear artisan-migrate artisan-db-seed
restart: down up
pre-commit: ecs-fix analyze-code
###< composite commands ###

###> work with docker ###
up:
	$(DOCKER_COMPOSE) up -d
down:
	$(DOCKER_COMPOSE) down --remove-orphans
down-with-remove-volumes:
	$(DOCKER_COMPOSE) down -v --remove-orphans
build:
	$(DOCKER_COMPOSE) build
config:
	$(DOCKER_COMPOSE) config
###< work with docker ###

###< composer ###
# example(info): make composer-command
# example: make composer-command COMMAND="show"
composer-command:
	$(COMPOSER) $(COMMAND)
composer-install:
	$(COMPOSER) install
composer-update:
	$(COMPOSER) update
###> composer ###

###< artisan ###
# example(info): make artisan-command
# example: make artisan-command COMMAND="debug:router --show-controllers"
artisan-command:
	$(ARTISAN) $(COMMAND)
artisan-cache-clear:
	$(ARTISAN) cache:clear
artisan-config-clear:
	$(ARTISAN) config:clear
artisan-migrate:
	$(ARTISAN) migrate
artisan-db-seed:
	$(ARTISAN) db:seed
artisan-user-view:
	$(ARTISAN) user:view 2
###> artisan ###

###< test ###
test:
	$(CODECEPTION) run
test-modular:
	$(CODECEPTION) run modular
test-integration:
	$(CODECEPTION) run integration
test-functional:
	$(CODECEPTION) run functional
test-api:
	$(CODECEPTION) run api
test-coverage:
	$(CODECEPTION) run integration,modular --coverage --coverage-html
# if you moved the test, there may be an failed - the clean call will help
test-clean:
	$(CODECEPTION) clean
###> test ###

###< code quality ###
ecs-check:
	$(ECS) check
ecs-fix:
	$(ECS) check --fix
ecs-clear-cache:
	$(ECS) check --clear-cache
analyze-code:
	$(PHPSTAN) analyse
###> code quality ###

###> other commands ###
copy-env:
	cp .env.example .env
	cp api/.env.example api/.env
	cp api/.env.test.example api/.env.test
	cp api/.env.stage.example api/.env.stage
	cp api/.env.prod.example api/.env.prod
###< other commands ###
