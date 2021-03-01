# Docker + Lumen with Nginx, MySQL, and Memcached

![image](Lumen_splash.png)

## Why?

Setting up an entire Lumen stack can be time consuming. This repo is a quick way to write apps in PHP using Lumen from an any Docker client. It uses docker-compose to setup the application services, databases, cache, etc...

## Clone this repo

```bash
git clone https://github.com/saada/docker-lumen.git
cd docker-lumen
```

## Create Lumen App

now, create the app in the `images/php` directory named `app`

```bash
cd images/php
docker run --rm -it -v $(pwd):/app saada/lumen-cli lumen new app
```

### Configuration

There are two configurations using `.env` files. One `.env` file for docker-compose.yaml and another for the php application.

```sh
# copy both files and make changes to them if needed
cp .env.docker.example .env
cp .env.app.example images/php/app/.env
```

To change configuration values, look in the `docker-compose.yml` file and change the `php` container's environment variables. These directly correlate to the Lumen environment variables.

## Docker Setup

### [Docker for Mac](https://docs.docker.com/docker-for-mac/)

### [Docker for Windows](https://docs.docker.com/docker-for-windows/)

### [Docker for Linux](https://docs.docker.com/engine/installation/linux/)

### Build & Run

```bash
docker-compose up --build -d
```

Navigate to [http://localhost:80](http://localhost:80) and you should see something like this
![image](Lumen_browser.png)

Success! You can now start developing your Lumen app on your host machine and you should see your changes on refresh! Classic PHP development cycle. A good place to start is `images/php/app/routes/web.php`.

Feel free to configure the default port 80 in `docker-compose.yml` to whatever you like.

### Stop Everything

```bash
docker-compose down
```

## Running Artisan commands

```sh
docker-compose exec php sh
# inside the container
cd ..
php artisan migrate
php artisan cache:clear
```

## Contribute

Submit a Pull Request!
