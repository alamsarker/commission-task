FPM=calculator

.PHONY : start fpm phpunit stop script

start:
	docker-compose down
	docker-compose up -d

fpm:
	docker exec -it $(FPM) bash

composer-install:
	docker exec -it $(FPM) bash -c 'composer install'

phpunit:
	docker exec -it $(FPM) bash -c './bin/phpunit --testdox'

calculate-commission:
	docker exec -it $(FPM) bash -c 'php console commission-calculator input.csv'
stop:
	docker-compose down