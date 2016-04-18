# Docker + Lumen with Nginx and MySQL

This setup is great for writing quick apps in PHP using Lumen from an OSX machine. It uses Virtualbox and docker-machine to create the actual environment and then uses compose to setup the application services.

## Clone this repo

```bash
git clone https://github.com/saada/docker-lumen.git
cd docker-lumen
```

## Create Lumen App

If you haven't already installed lumen globally, run

```
composer global require "laravel/lumen-installer=~1.0"
```

now, create the app in the `images\php` directory named `app`

```
cd images/php
lumen new app
```

### Configuration

To change configuration values, look in the `docker-compose.yml` file and change the `php` container's environment variables. These directly correlate to the Lumen environment variables.

## Docker Setup
### Install [Docker Toolbox](https://www.docker.com/products/docker-toolbox)

### Setup docker environment

```
docker-machine create -d virtualbox default
docker-machine start
eval $(docker-machine env)
```

### Build & Run!

```
docker-compose up --build -d
```
you can now start writing your app!  

Your docker machine IP can be found via

```
docker-machine ip
```

### Stop

```
docker-compose stop
```
