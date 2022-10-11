DOCKER_COMPOSE_RUN=docker-compose run --rm
DOCKER_COMPOSE_RUN_XDEBUG_OFF=docker-compose run --rm \
	-e XDEBUG_MODE=off \

DOCKER_RUN_ONCE_MAC_WITH_SSH_AGENT=$(DOCKER_COMPOSE_RUN) \
	-v /run/host-services/ssh-auth.sock:/tmp/ssh-agent \
	app

DOCKER_RUN_ONCE_LINUX_WITH_SSH_AGENT=$(DOCKER_COMPOSE_RUN) \
	-v /etc/passwd:/etc/passwd:ro \
	-v /etc/group:/etc/group:ro \
	-v ${SSH_AUTH_SOCK}:/tmp/ssh-agent \
	-e XDEBUG_MODE=off \
	app

composer:
	$(DOCKER_RUN_ONCE_LINUX_WITH_SSH_AGENT) composer validate --ansi --no-interaction --strict
	$(DOCKER_RUN_ONCE_LINUX_WITH_SSH_AGENT) composer install --ansi --no-interaction

composer-require:
	$(DOCKER_RUN_ONCE_LINUX_WITH_SSH_AGENT) composer require $(package)

.PHONY: run
run: ## start application
	$(DOCKER_COMPOSE_RUN) app ./vendor/bin/bref local --handler=index.php --file=event.json

.PHONY: coverage
coverage:
	$(DOCKER_COMPOSE_RUN) coverage php -dpcov.enabled=1 -dpcov.directory=src -dpcov.exclude="~vendor~" ./vendor/bin/phpunit

.PHONY: shell
shell: ##spawns shell in container
	docker exec -it connect_php_1 ash

.PHONY: cs-check
cs-check: ##dry-run
	$(DOCKER_COMPOSE_RUN_XDEBUG_OFF) app vendor/bin/ecs check

.PHONY: cs-fix
cs-fix: ##
	$(DOCKER_COMPOSE_RUN_XDEBUG_OFF) app vendor/bin/ecs check --fix
