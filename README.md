# open-ecommerce
[![Docker Image CI](https://github.com/dhanyn10/open-ecommerce/actions/workflows/docker-image.yml/badge.svg)](https://github.com/dhanyn10/open-ecommerce/actions/workflows/docker-image.yml)
[![Unit and Feature tests via PHPUnit](https://github.com/dhanyn10/open-ecommerce/actions/workflows/simple-test.yml/badge.svg)](https://github.com/dhanyn10/open-ecommerce/actions/workflows/simple-test.yml)  
open source version for my e-commerce sites. This project currently in slow development

### Guides
#### Installation without Docker
- install all required dependencies `composer install`. Currently you need to use composer version 2.*
- create database `open_ecommerce` from your phpmyadmin
- remove exisiting `.env` file and rename file `.env.old` to `env`
- This apps used RajaOngkir to generate the address and calculate delivery cost. So, you need to Register to [rajaongkir](https://rajaongkir.com/akun/daftar) to get the API key. Then fill `RAJAONGKIR_API_KEY` in `.env` file with your own key.
- migrate the database from database/migration using command `php artisan migrate`
- you can use optional features to generate users data instantly using command `php artisan db:seed`.

#### Installation with Docker
- previously, make sure you already installed docker and docker-compose on your operating system
- This apps used RajaOngkir to generate the address and calculate delivery cost. So, you need to Register to [rajaongkir](https://rajaongkir.com/akun/daftar) to get the API key. Then fill `RAJAONGKIR_API_KEY` in `.env` file with your own key.
- install and run this web apps with command `docker-compose up -d`
- wait for 10s or more and run migration function command `docker exec oe-web php artisan migrate`
- run database seeding function with command `docker exec oe-web php artisan db:seed`

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