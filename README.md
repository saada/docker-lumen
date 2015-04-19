# Docker + Lumen with Nginx and MySQL

This setup is great for writing quick apps in PHP using Lumen from an OSX machine. It uses Virtualbox and docker-machine to create the actual environment and then uses compose to setup the application services.

### Create Lumen App

If you haven't already installed lumen globally, run

```
composer global require "laravel/lumen-installer=~1.0"
```

now, create the app in the `images\php` directory named `app`

```
cd images/php
lumen new app
```

### Install docker, compose, and machine

```
brew update
brew install docker docker-compose docker-machine
```


### InstallVirtualbox
[Download Virtualbox](https://www.virtualbox.org/wiki/Downloads)

### Setup docker environment

```
docker-machine create -d virtualbox dev
docker-machine start dev
$(docker-machine env dev)
```

### Build & Run!

```
docker-compose build
docker-compose up -d
```
you can now start writing your app!  

Your docker machine IP can be found via

```
docker-machine ls
```

### Stop

```
docker-compose kill
```
