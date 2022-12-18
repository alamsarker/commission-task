# Commission Calculator

Commission Calculator for deposit and withdrawal operation of private and business client

## Installation & Run

* Pull the repository ``
* Start Container: `make start`
* Install Composer : `make composer-install`
* Run the cli: `make calculate-commission`
* Run unit test: `make phpunit`
* Stop the container: `make stop`


## Important Notes

* Currency is converting for all types of opration, though the task said for withrawal operation for private client.
* Added cacheing machanism for creating object in `ClientFacotry->create()` method.
* Optimsed rate exchange api, loading config file by loading once for per command.


## Technology

* PHP 8.1
* Docker
* Docker-compose
