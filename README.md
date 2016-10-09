# Docker + Lumen with Nginx and MySQL

This setup is great for writing quick apps in PHP using Lumen from an any Docker client. It uses docker-compose to setup the application services.

## Clone this repo

```bash
git clone https://github.com/saada/docker-lumen.git
cd docker-lumen
```

## Create Lumen App

If you haven't already installed lumen globally, run

```
composer global require "laravel/lumen-installer"
```

now, create the app in the `images\php` directory named `app`

```
cd images/php
lumen new app
```

### Configuration

To change configuration values, look in the `docker-compose.yml` file and change the `php` container's environment variables. These directly correlate to the Lumen environment variables.

## Docker Setup
### [Docker for Mac](https://docs.docker.com/docker-for-mac/)
### [Docker for Windows](https://docs.docker.com/docker-for-windows/)
### [Docker for Linux](https://docs.docker.com/engine/installation/linux/)

### Build & Run!

```
docker-compose up --build -d
```
Navigate to [http://localhost:80](http://localhost:80) and you can now start developing your Lumen app on your host machine and you should see your changes on refresh! Classic PHP development cycle. 

Feel free to configure the port in `docker-compose.yml` to whatever you like.

### Stop Everything

```
docker-compose down
```
