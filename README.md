###  Calculate commissions for already made transactions;
##### About The Project 
* from file: transactions/transactions.txt
* the data were handled in /src/Controller/AppController.php
* file comfig/env.php has config constants for the project settings: api links, paths to files, commission rates etc.
* PSR 12 standart, except warning: length more than 120 charactrers

##### Built With
*  php8.2
*  phpunit
*  enum - for a list of user agents
*  match

##### Prerequisites
* php 8.2

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
##### Error
* when request to https://lookup.binlist.net/"
*  error 429 too much request:  
