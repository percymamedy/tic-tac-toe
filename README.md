## TicTacToe Demo App

### Stack I used

``Api``
- Laravel (PHP)
- mariadb

```web```
- VueJs

### Packages used for the Api that was essential

- [spatie/laravel-cors](https://github.com/spatie/laravel-cors)
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
- [BenSampo/laravel-enum](https://github.com/bensampo/laravel-enum)

### Libraries used for the Web

- Vue
- VueX
- VueRouter
- Tailwind
- Fontawesome

### Project runtime

- Api is running on docker containers, I've used a small portion 
of [laradock](https://github.com/LaraDock/laradock) to get up and running quickly via a tool
called [Dcompose](https://github.com/percymamedy/Dcompose) that I've built.

- Web, I've scaffold and run with [VueCli](https://cli.vuejs.org/). Dependencies I've pulled
via npm.

### Installation

To run the project you'll need ```docker``` and ```docker-compose``` and ```node```.

#### Install the back-end Api

Clone the project first:

```bash
git clone https://github.com/percymamedy/tic-tac-toe.git
```

Copy the docker ```env```:

```bash
cd Api/.docker
```

```bash
cp env-example .env
```

Run the docker containers:

```bash
docker-compose up -d
```

SSH into the workspace container and install dependencies:

```bash
docker-compose exec --user=laradock workspace bash
```

```bash
cp .env.example .env
```

```bash
composer install
```

```bash
php artisan key:generate
```

Migrate the database:

```bash
php artisan migrate
```

You can now exist the Workspace container

#### Install the web front-end

Go to the root of the web folder and install dependencies using npm:

```bash
cp web
```

```bash
npm install
```

If you are building for developement:

```bash
npm run serve
```

If you are building for production:

```bash
npm run build
```

Production build is in ```web/dist```

You should now be up and running

### Creator
[![Percy Mamedy](https://img.shields.io/badge/Author-Percy%20Mamedy-orange.svg)](https://twitter.com/PercyMamedy)

Twitter: [@PercyMamedy](https://twitter.com/PercyMamedy)
<br/>
GitHub: [percymamedy](https://github.com/percymamedy)
