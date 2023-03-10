# Commission Calculator

Commission Calculator for deposit and withdrawal operation of private and business client

## Installation & Run

 ### Docker and docker-compose is required to run the following commands

* Pull the repository `git@github.com:alamsarker/commission-task.git`
* Start Container: `make start`
* Install Composer : `make composer-install`
* Run the cli: `make calculate-commission`
* Run unit test: `make phpunit`
* Stop the container: `make stop`


## Notes

* Currency is converting for all types of operation, though the task is said for withrawal operation for private client.
* Added cacheing machanism for creating Client object in `ClientFacotry->create()` method.
* Optimsed the rate exchange api, loading config file once for per command.
* Used set* method instead of constructor in `App\Formatter\RoundedUpFormatter` & `App\CurrencyConverter\BaseCurrencyConverter` classes as creating instance in consle file looks not good.


## Technology

* PHP 8.1
* Docker
* Docker-compose
