# Barkyn Backend Challenge

RESTful API developed for the barkyn's backend challenge
## Installation

Clone repository from [Github](https://github.com/Hallysonjp/barkyn-challenge)


Build Docker images 
```bash
docker-compose up -d
```

Access the container using
```bash
docker exec -it php sh
```
Install composer packages
```bash
composer install
```

create .env file
```bash
cp .env.example .env
```

Run migrations
```bash
php artisan migrate:fresh
```
Generate JWT_SECRET environment variable
```bash
php artisan jwt:secret
```
Run seeds
```bash
php artisan db:seed --class=UsersTableSeeder
php artisan db:seed --class=CustomersTableSeeder
```


## Documentation
The Postman Documentation can be accessed [here](https://documenter.getpostman.com/view/2659081/Uyr5oeeH)

## License
[MIT](https://choosealicense.com/licenses/mit/)
