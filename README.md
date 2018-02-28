# Vehicles API made in PHP Laravel 5.4.36

This API return a list of vehicles when provided the model, manufacture and model-year of the vehicles. The data is extracted from the NHTSA API.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

What things you need to install the software

1. Download and install git: [installing github](https://gist.github.com/derhuerst/1b15ff4652a867391f03)
2. Download and install composer, you can follow the instructions on this link:
[installing composer](https://getcomposer.org/doc/00-intro.md)

### Installing the Project API Vehicles

First you need to clone the repository in your machine, that command will create a folder called php-api-vehicles

```
git clone https://github.com/gabazureus/php-api-vehicles
```

To run the project you need to install the modules and the dependencies

```
composer install
```

After that, you need to copy the .env.example to .env

**If you are in Windows use**

```
copy .env.example .env
```

**If You are in Linux use**

```
cp .env.example .env
```

Than, you need to generate the keys to your Laravel application

```
php artisan key:generate
```

## Running the project

To run the project you just need to execute this command

```
php artisan serve --port 8000
```

and then this output will be in presented in the screen

```
Laravel development server started: <http://127.0.0.1:8000>
```

## Running the tests
The tests will run in http://127.0.0.1:8000/ so it is important to execute the php artisan serve in the port 8000.

To perform the tests I used the Swaggest JsonDiff, that help me to compare what was expected (presented in php-api-assignment) and what was returned by my API.

To run the tests you just simple execute this instruction in your command line

**If you are in Windows use**
```
"vendor\bin\phpunit"
```

**If you are in Linux use**
```
./vendor/bin/phpunit
```

### Tests that will run

You can find bellow all the API Requests that will be tested

```
POST /vehicles?modelYear=2015&manufacture=Audi&model=A3&withRating=true
POST /vehicles?modelYear=2015&manufacture=Audi&model=A3&withRating=false
POST /vehicles?modelYear=2015&manufacture=Toyota&model=Yaris&withRating=bananas
POST /vehicles?manufacture=Toyota&model=Yaris (without modelYear)
```

```
GET /vehicles/2015/Audi/A3
GET /vehicles/2015/Toyota/Yaris
GET /vehicles/2015/Audi/A3?withRating=true
GET /vehicles/2015/Toyota/Yaris?withRating=true
GET /vehicles/undefined/Audi/A3
GET /vehicles/bananas/Audi/A3
GET /vehicles/2015/Ford/Crowd%20Victoria
GET /vehicles/2015/Ford
```

If  that will be correct, it will return an OK message.

## Built With

* [Composer 1.4.1](https://getcomposer.org) - Dependency Manager for PHP
* [Laravel 5.4.36](https://github.com/laravel/framework) - PHP Framework
* [Swaggest JsonDiff](https://github.com/swaggest/json-diff) - A PHP implementation for finding unordered diff between two JSON documents
* [GuzzleHttp](https://github.com/guzzle/guzzle) - Extensible PHP HTTP client

## API Documentation

I used the [Swagger UI](https://swagger.io/swagger-ui/) for documenting the API.

You just need to download the /dist folder in this project and open the index.html inside this folder to see the API documentation.
Or you can just click this link:

[API Documentation](https://rawgit.com/gabazureus/php-api-vehicles/master/dist/index.html)

## Author

* **Gabriel Silva Sorrentino**

## Acknowledgments

* I would like to work in Modus Create to create a better future with technology and innovation,
* and because I like to learn anything new every single day.
* Thanks =)
