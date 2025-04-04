.PHONY : main build-image build-container start test shell stop clean
main: build-image build-container

build-image:
	docker build -t docker-php-user-login-module .

build-container:
	docker run -dt --name docker-php-user-login-module -v .:/540/UserLoginModule docker-php-user-login-module
	docker exec docker-php-user-login-module composer install

start:
	docker start docker-php-user-login-module

test: start
	docker exec docker-php-user-login-module ./vendor/bin/phpunit tests/$(target)

shell: start
	docker exec -it docker-php-user-login-module /bin/bash

stop:
	docker stop docker-php-user-login-module

clean: stop
	docker rm docker-php-user-login-module
	rm -rf vendor
