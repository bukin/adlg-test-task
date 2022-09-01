<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg" alt="logo-laravel"></p>

<p><strong>Prepare virtual machine</strong></p>

- cp .env.local .env
- <strong>[Optional]</strong> cp docker-compose.override.example.yml docker-compose.override.yml
- docker-compose up -d
- docker-compose exec php composer install
- docker-compose exec php php artisan key:generate (For init project or .env / APP_KEY is empty)
- docker-compose exec php php artisan storage:link

<p><strong>Prepare DB</strong></p>

- docker-compose exec php php artisan migrate
- docker-compose exec php php artisan inetstudio:acl:roles:seed
- Create admin user and get API token: docker-compose exec php php artisan app:make:admin
- docker-compose exec php php artisan db:seed --class="\Bukin\ProductsPackage\Products\Domain\Entity\ProductSeeder"
- docker-compose exec php php artisan db:seed --class="\Bukin\ProductsPackage\Vendors\Domain\Entity\VendorSeeder"

<p><strong>Misc</strong></p>

- Run tests: docker-compose exec php php artisan test packages/bukin/products-package
- Postman collection: Dialog.postman_collection.json
- Show products by console command: docker-compose exec php php artisan bukin:products-package:products:show

<p><strong>Console Aliases</strong></p>

- alias dcphp="docker-compose exec php php"
- alias dcphpa="docker-compose exec php php artisan"
- alias dcphpc="docker-compose exec php composer"
- alias dcphp_stan="docker-compose exec php ./vendor/bin/phpstan analyse"
- alias dcphp_exd="docker-compose exec php sh -l -c enable-xdebug"
- alias dcphp_dxd="docker-compose exec php sh -l -c disable-xdebug"
