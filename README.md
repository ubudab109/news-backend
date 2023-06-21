# NEWS FEED APPLICATION
### THIS IS THE BACKEND APPLICATION FOR NEWS FEED

## Requirements
- Docker Compose (Make sure You have Docker in Your operating system) https://www.docker.com/

## TECH STACK
- Laravel Framework
- MySQL
- PHP 8

## NEWS SOURCES USED
- News API AI (https://www.newsapi.ai/)
- The Guardian (https://open-platform.theguardian.com/)
- News API ORG (https://newsapi.org/)

## INSTALLATION
- Run `docker-compose up -d --build` in terminal to build docker image and container
- After image and container successfully build. Run this command:
  - Using WINDOWS CMD
    `docker exec -it php-apache /bin/sh` or `docker exec -it php-apache //bin//sh`
  - Using Git Bash
    `winpty docker exec -it php-apache //bin//bash`
  - Using Linux Terminal
    `docker exec -it php-apache /bin/sh`
- Run `cp .env.example .env` to create the environment variables
- Run `composer install` or `composer install --ignore-platform-reqs` if `composer install` doesn't work
- Run `composer dump-autoload`
- Run `php artisan migrate` to migrate all table to database
- Run `php artisan db:seed` to seeding the data to each table
- After run seeding. Run this command `php artisan queue:work` to import sources data such as Sources, Articles, Authors and Categories. Wait until process is complete.
- Installation complete.
- This application will running on this port `http://localhost:8080`

## DEFAULT CREDENTIAL
- email: user@mail.com
- password: 123456

## API Collection
#### Import this file into postman to look the documentation API `https://drive.google.com/file/d/1AKLWFpfG2ucM4TXJgQrxvEsTZFhnZSWP/view?usp=sharing`



