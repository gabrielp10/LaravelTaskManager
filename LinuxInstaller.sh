#!/bin/bash
# Clone the repository
git clone https://github.com/GabrielTSants/LaravelTaskManager;

# Enter the repository
cd LaravelTaskManager;

# Create the .env
cp .env.example .env;

# Run the docker
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs;

# Start the server 
./vendor/bin/sail up -d;

# Generate the key
./vendor/bin/sail php artisan key:generate;

# Migrate the database on another terminal
./vendor/bin/sail php artisan migrate;

# Run the docker server
./vendor/bin/sail up;

# You can now access the project in 0.0.0.0:80 and PHPMyAdmin in 0.0.0.0:8080


