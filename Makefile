project = sig

all: build

install-deps:
	docker-compose -p $(project) run --no-deps sig  composer install

update-deps:
	docker-compose -p $(project) run --no-deps sig composer update

run: 
	docker-compose -p $(project) up

start: 
	docker-compose -p $(project) up -d

stop: 
	docker-compose -p $(project) stop
	docker-compose -p $(project) rm
	docker-compose -p $(project) -f docker-compose.test.yml stop
	docker-compose -p $(project) -f docker-compose.test.yml  rm

test:
	docker-compose -p $(project) -f docker-compose.test.yml up -d
	docker-compose -p $(project) -f docker-compose.test.yml run tester vendor/bin/behat

build:
	docker build -t cncflora/$(project) .

push:
	docker push cncflora/$(project)

