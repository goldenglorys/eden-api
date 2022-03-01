<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Eden Work Sample

Welcome to the Garden of Eden!

This work sample is a simple API with various consumable endpoints which are available through the API documentation page.

The API simply has but not limited to:

- Automated Testing.
- API caching for up to 3 minutes on any get requests.
- Embeded && interactive API documentation. 
- Simplicity by design in it's own minimal level.

## Getting Started
---------------

#### Via Cloning The Repository:

[PHP](https://php.net) 8.0+ and [Composer](https://getcomposer.org) plus a databse (MySQL or PostgresSQL) are required.

```bash
# Get the project
git clone https://github.com/goldenglorys/eden-work-sample.git

# Change directory
cd eden-work-sample

# Install Composer dependencies
composer install or composer update

# Copy .env.example to .env
cp .env.example .env

# Create a database (with mysql or postgresql)
# And update .env file with database credentials
# DB_CONNECTION=mysql OR pgsql
# DB_HOST=127.0.0.1
# DB_DATABASE=eden
# DB_USERNAME=####
# DB_PASSWORD=####

# Run the database migration and the initial seeding data using
php artisan migrate --seed

# Generate application secure key (in .env file)
php artisan key:generate

# Run the application using
php artisan serve
```

## Run Tests

To run the automated tests, issue the command:

    php artisan test

The test dosen't generate the coverage statistics, feel free adding that.

## Live URLs

- [API URL](https://eden-sample-api.herokuapp.com/api/v1): Hits the API home/welcome endpoint.
- [API Documentation](https://eden-sample-api.herokuapp.com/api/documentation): Lands on the embeded/interatice API documentaion.

## License

The code is open-sourced, licensed under the [MIT license](https://opensource.org/licenses/MIT).

 <h2 align="center">Made possible by <b>PHP</b><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="150" height="50"></a>With ❤️</h2>

 Happy Coding!!