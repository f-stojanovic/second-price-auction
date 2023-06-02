# Second Price Auction Algorithm

**Symfony 5.4 project**

### Environment
- nginx 1.23.4
- php-fpm 8.1.18
- mysql 8.0

### Requirements
Docker compose, Git and as the main IDE is PhpStorm (preferably the latest version with Shell Configuration supports).

### Installation
Open project root folder and run next configurations:
1. Open terminal and run: `docker-compose build`
2. Then: `docker-compose -f docker-compose.yml up`
3. Enter the PHP container: `docker exec -it second-price-auction-php-1 /bin/bash`
4. In the container run `composer install` (after execute, it will take a little time to index the installed vendors)
5. Run the command `php bin/console doctrine:migrations:migrate` to populate database
6. Then run the command `php bin/console doctrine:fixtures:load` so you can load the fixtures.
7. Run the test with: `php bin/phpunit`
8. By running command `./vendor/bin/phpmd src/ text phpmd.xml` and check the code with this code quality tool

On the http://localhost/ you can check the result described in the task.

Hope you like it.. :) 