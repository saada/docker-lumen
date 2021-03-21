# Pizza API


### Tools / Frameworks used

* Lumen
* Docker
* MySQL

## Install & Start

* Install docker for your OS
* All other dependencies are installed automatically
* Start using:

```bash
$ docker-compose up
```

## Migrate database

```bash
$ docker-compose exec php artisan migrate
```


## Run test suite

```bash
$ docker-compose exec php phpunit
```

## Regenerate OpenApi Docs

```bash
$ docker-compose exec php openapi app/ -o api.json
```

## Accessing API and docs

* The api is accessible under `localhost:80`
* The docs are accessible under `localhost:8080`
