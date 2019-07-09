# mangoapi
PHP library to handle API requests and send responses.

# Requirements
------------

- PHP version 7.0+
- [composer](http://getcomposer.org).

# Install with composer
------------

The best way to add the library to your project is using [composer](http://getcomposer.org).
```bash
composer require faraweilyas/mangoapi
```
or

# Clone this repo

```bash
git clone https://github.com/faraweilyas/mangoapi.git
```

# Basic usage
-------------
```php
<?php

use MangoAPI\Request;
use MangoAPI\Response;

require_once 'vendor/autoload.php';

// Handling request
$request = new Request();
$request->addHeader("Access-Control-Allow-Origin", "*")
		->addHeader("Content-Type", "application/json; charset=UTF-8")
		->setAllowMethods(["GET", "POST", "PUT", "HEAD", "DELETE", "PATCH", "OPTIONS"])
		->addHeader("Access-Control-Max-Age", "3600")
		->addHeader("Access-Control-Allow-Credentials", "true")
		->addHeader("Access-Control-Allow-Headers", "Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With")
		->setHeaders();

// Make database calls or any other operations

// Sending response
$response 	= new Response;
$data 		= ['username' => 'hadiza123', 'name' => 'Agbonoga Hadiza', 'sex' => 'female'];
$response->isOk("Successfully processed", $data)
		->send()
		->kill();

```

## Handling Request
```php
$request = new Request();
// Add header 1
$request->addHeader("Access-Control-Allow-Origin", "*");
// Add header 2
$request->addHeader("Access-Control-Max-Age", "3600");
// Setting header
$request->setHeaders();

// Get raw data from request
$data = $request->getDataFromRequest();

// Get headers
$headers = $request->getHeaders();
```

## Sending Response

- Send 200 ok response
```php
$response 	= new Response;
$data 		= ['username' => 'hadiza123', 'name' => 'Agbonoga Hadiza', 'sex' => 'female'];
$response->isOk("Successfully processed", $data)
		->send()
		->kill();
```
- Send 201 created response
```php
$response 	= new Response;
$data 		= ['username' => 'hadiza123', 'name' => 'Agbonoga Hadiza', 'sex' => 'female'];
$response->isCreated("Successfully created", $data)
		->send()
		->kill();
```
- Send 400 bad request response
```php
$response 	= new Response;
$data 		= [];
$response->badRequest("Request can't be processed", $data)
		->send()
		->kill();
```
- Send 404 not found response
```php
$response 	= new Response;
$response->notFound("Request not found")
		->send()
		->kill();
```
- Send 422 unprocessable entity response
```php
$response 	= new Response;
$response->unProcessableEntityResponse()
		->send()
		->kill();
```
