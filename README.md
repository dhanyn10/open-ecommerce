# open-ecommerce
open source version for my e-commerce sites. This project currently in slow development

### Guides
- install all required dependencies `composer install`. Currently you need to use composer version 1.*
- create database `open_ecommerce` from your phpmyadmin
- migrate the database from database/migration using command `php artisan migrate`
- you can use optional features to generate the admin data instantly using command `php artisan db:seed`
  here's the data for the admin:
  ```
  email   : admin@open_ecommerce
  name    : admin
  password: admin
  ```
