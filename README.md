# open-ecommerce
open source version for my e-commerce sites. This project currently in slow development

### Guides
- install all required dependencies `composer install`. Currently you need to use composer version 1.*
- create database `open_ecommerce` from your phpmyadmin
- migrate the database from database/migration using command `php artisan migrate`
- you can use optional features to generate users data instantly using command `php artisan db:seed`. Here's the data, for:  
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