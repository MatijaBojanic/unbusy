# UnBusy

### UnBusy is a simple, easy to use public transport application.

## Get the project up and running

* Install git, php, composer and docker

* Get the project from git

    `git clone https://github.com/MatijaBojanic/unbusy.git`

* Go to the project directory

    `cd unbusy`

- Create a .env file from .env.example and fill in the blanks
- Run the following command to get all the dependencies installed:

       docker run --rm \  
           -u "$(id -u):$(id -g)" \  
           -v "$(pwd):/var/www/html" \  
           -w /var/www/html \  
           laravelsail/php82-composer:latest \  
           composer install --ignore-platform-reqs
- Get the containers up and running:

    `./vendor/bin/sail up`

    `./vendor/bin/sail artisan migrate`

- Create a super user
    
    `./vendor/bin/sail artisan create:super-user {your email} {your password}`
