DOCKER=docker
FOLDER_DOCKER=docker

# container names
PHP_CONTAINER_NAME=$(DOCKER)_php-fpm_1
DB_CONTAINER_NAME=$(DOCKER)_mariadb_1
NGINX_CONTAINER_NAME=$(DOCKER)_nginx_1
REDIS_CONTAINER_NAME=$(DOCKER)_redis_1
ADMINER_CONTAINER_NAME=$(DOCKER)_adminer_1
NODE_IMAGE_NAME=node

# mysql variables
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

# date
DATE=$(shell date +'%Y-%m-%d')

LIST_OF_CONTAINERS_TO_RUN=nginx mariadb php-fpm adminer


# some variables that required by installation target
LARADOCK_REPO=https://github.com/bazavlukd/laradock.git

# the first target is the one that executed by default
# when uesr call make with no target.
# let's do nothing in this case
.PHONY: nop
nop:
	@echo "Please pass a target you want to run"

# custom targets

# put them here

#--------

# clone the repo
# replace some variabls in laradock's .env file
# create and update .env file of laravel
# replace some env variables in laravel's .env file
.PHONY: install-laradock
install-laradock:
	cd $(LARADOCK) && git clone $(LARADOCK_REPO) $(LARADOCK) && \
	cp $(LARADOCK)/env-example $(LARADOCK)/.env && \
	sed -i "/DATA_PATH_HOST=.*/c\DATA_PATH_HOST=..\/docker-data" $(LARADOCK)/.env && \
	(test -s .env || cp .env.example .env) ; \
	sed -i "/DB_CONNECTION=.*/c\DB_CONNECTION=mysql" .env && \
	sed -i "/DB_HOST=.*/c\DB_HOST=mysql" .env && \
	sed -i "/DB_DATABASE=.*/c\DB_DATABASE=$(DB_DATABASE)" .env && \
	sed -i "/DB_USERNAME=.*/c\DB_USERNAME=$(DB_USERNAME)" .env && \
	sed -i "/DB_PASSWORD=.*/c\DB_PASSWORD=$(DB_PASSWORD)" .env && \
	sed -i "/REDIS_HOST=.*/c\REDIS_HOST=redis" .env && \
	chmod -R 777 storage

# run initial scriptscd
# key generate
# fix mysql passwords
# run migrations/seeds
# install composer dependencies
# install js dependencies
.PHONY: initial-build
initb:
	docker exec -it $(DB_CONTAINER_NAME) mysql -u root -proot -e "ALTER USER '$(DB_USERNAME)' IDENTIFIED WITH mysql_native_password BY '$(DB_PASSWORD)';";

# run all containers
.PHONY: up
up:
	cd $(FOLDER_DOCKER) && docker-compose up -d $(LIST_OF_CONTAINERS_TO_RUN)

# stop all containers
.PHONY: down
down:
	cd $(FOLDER_DOCKER) && docker-compose down

.PHONY: start-portainer
upp:
	cd $(FOLDER_DOCKER) && docker-compose up -d portainer

.PHONY: stop-portainer
downp:
	cd $(FOLDER_DOCKER) && docker-compose down portainer

#run rebuild all containers
.PHONY: rebuild-containers
reup:
	cd $(FOLDER_DOCKER) && docker-compose up -d --no-deps --build $(LIST_OF_CONTAINERS_TO_RUN)

.PHONY: rebuild-php-fpm
repf:
	cd $(FOLDER_DOCKER) &&  docker-compose up -d --no-deps --build $(PHP_CONTAINER_NAME)

.PHONY: rebuild-mariadb
resql:
	cd $(FOLDER_DOCKER) &&  docker-compose up -d --no-deps --build $(POSTGRES_CONTAINER_NAME)

.PHONY: rebuild-nginx
renginx:
	cd $(FOLDER_DOCKER) &&  docker-compose up -d --no-deps --build $(NGINX_CONTAINER_NAME)

.PHONY: rebuild-adminer
readminer:
	cd $(FOLDER_DOCKER) && docker-compose up -d --no-deps --build $(ADMINER_CONTAINER_NAME)


# show docker log
.PHONY: docker-log
dlog:
	cd $(FOLDER_DOCKER) && docker-compose logs -f && cd ..

# JOIN containers targets

.PHONY: join-workspace
jw:
	cd $(FOLDER_DOCKER) && docker exec -it $(PHP_CONTAINER_NAME) bash

.PHONY: join-php
jphp:
	cd $(FOLDER_DOCKER) && docker exec -it $(PHP_CONTAINER_NAME) bash

.PHONY: join-db
jdb:
	cd $(FOLDER_DOCKER) && docker exec -it $(DB_CONTAINER_NAME) mariadb -u maks -p

.PHONY: join-nginx
jnginx:
	cd $(FOLDER_DOCKER) && docker exec -it $(NGINX_CONTAINER_NAME) bash



#------------------

# queue related targets
.PHONY: queue-flush
queue-flush:
	cd $(FOLDER_DOCKER) && docker exec -it $(REDIS_CONTAINER_NAME) redis-cli flushall && cd ..
#------------------

# some artisan helpers

#policiec maks
.PHONY: chown
chown:
	sudo chown maks:users -R ./

.PHONY: git push
push:
	git push origin master

.PHONY: git pull
pull:
	git pull origin master
