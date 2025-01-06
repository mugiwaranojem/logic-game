## Prerequisite
- Docker 2.4 (or latest)
- Docker Compose 1.27.4 (or latest, usually included in docker insall setup)
- Composer 2.0 (or latest)
- Git
- PHP 7.4 or higher
- Mysql Client (Workbench or DBeaver)
- Postman (Optional)

## Stacks
- Laravel
- Docker
- docker-compose
- VueJs
- Boostrap
- Mysql
- PHP 8.2


## Description
The app is build using docker mainly to containerize Laravel & DB,
Frontend on the otherhand is a separate setup where it can run on host machine and it calls API endpoint laravel,
In this architecture it is independent working for BE and FE, so different team can work on different stack without too much dependent on each other
Laravel app solely purpose is for API endpoint using Eloquent Resource API to easily manipulate data being passed to client
Service Pattern is demonstrated on this codebase were all logic reside in it, 
improvements would be to add a Repository layer were all data manipulation will handled here but the design is all good for simplicity for simple app

### Setup the APP
1. clone repo
```
git clone https://github.com/mugiwaranojem/logic-game.git
cd logic-game
docker-compose build
```
2. Setup BE
```
cd api
composer install
cp .env.example .env

# .env file should contain the follwing details
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=backend_db
DB_USERNAME=root
DB_PASSWORD=root

# to root folder, Spin up the containers
cd logic-game
docker-compose up

# in new window terminal, setup laravel app
docker exec -it logic_game_web php artisan key:generate
docker exec -it logic_game_web php artisan migrate
docker exec -it logic_game_web php artisan db:seed
```
2. Setup FE
```
cd frontend
npm install
npm run dev
```
3. Test the APP
Open in broswer http://localhost:5173/ or replace what ever port is being dispalyed in run dev in my case its :5173

### Running Unit Test
1. Create test db on mysql client
hostname: 127.0.0.1
port: 3306
username: root
password: root

```
CREATE SCHEMA `test_backend_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
```

2. Execute Unit test on BE container
```
docker exec -it logic_game_web php artisan test
```

### API Doc
```
# Import to PostMan
./api/api.postman_collection
```

### Scalability
The App supports adding multiple player, customize rounds and rules the configuration is save in db
Config are adjustable via postman request or api request:
```
POST http://localhost:8000/api/config/update
{
    "key": "rounds",
    "value": 10
}

POST http://localhost:8000/api/config/update
{
    "key": "player_number",
    "value": 3
}

```

### References
- https://laravel.com/docs/11.x#installing-php
- https://vuejs.org/guide/quick-start
- https://laravel.com/docs/11.x/eloquent-resources#main-content
