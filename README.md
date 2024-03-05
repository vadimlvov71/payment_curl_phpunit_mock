###  Calculate commissions for already made transactions;
##### About The Project 
* from file: transactions/transactions.txt
* the data were handled in /src/Controller/AppController.php
* file comfig/env.php has config constants for the project settings: api links, paths to files, commission rates etc.
* PSR 12 standart, except warning: length more than 120 charactrers

##### Built With
*  php8.1
*  phpunit
*  enum - for a list of user agents
*  match

##### Prerequisites
* php 8.1

##### Installation
1. Clone the repo
   ```sh
   git clone git@github.com:vadimlvov71/payment_curl_phpunit_mock.git
   ```
2. Composer
  ```sh
  composer install
  ```
<!-- GETTING STARTED -->
##### Getting Started
* app.php as entry point run "php app.php input.txt"
* ![изображение](https://github.com/vadimlvov71/payment_curl_phpunit_mock/assets/57807117/c3a9827d-6587-4e54-b6eb-38491a6522f2)

##### Error
* when request to https://lookup.binlist.net/"
*  error 429 too much request:  
##### phpUint tests with mock
* run vendor/bin/phpunit tests
* ![изображение](https://github.com/vadimlvov71/payment_curl_phpunit_mock/assets/57807117/c2c53e8e-da8e-4fc4-ae00-fdf63fd24ae6)

