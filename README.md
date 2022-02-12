# open-ecommerce
open source version for my e-commerce sites. This project currently in slow development

### Guides
#### Installation without Docker
- install all required dependencies `composer install`. Currently you need to use composer version 2.*
- create database `open_ecommerce` from your phpmyadmin
- remove exisiting `.env` file and rename file `.env.old` to `env`
- migrate the database from database/migration using command `php artisan migrate`
- you can use optional features to generate users data instantly using command `php artisan db:seed`.

#### Installation with Docker
- previously, make sure you already installed docker and docker-compose on your machine
- run command `docker-compose up -d` to run and install the web apps instantly
- wait for >= 10s and run command `docker exec oe-web php artisan migrate` to run the migration function
- run command `docker exec oe-web php artisan db:seed` to run database seeding function

#### Enjoy
Here's the data, for:  
  Admin
  ```
  email   : admin@open_ecommerce
  name    : admin
  password: admin
  ```
  Seller
  ```
  email   : penjual@open_ecommerce
  name    : penjual
  password: penjual
  ```
  Buyer
  ```
  email   : pembeli@open_ecommerce
  name    : pembeli
  password: pembeli
  ```
  All of generated username already confirmed by system. So you can used it to login.