# laravel-multiple-connections

php artisan make:model Local/Customer
php artisan make:model Mongo/Customer

php artisan make:migration create_customers_table --table=customers  --path=database/migrations/mongo

php artisan migrate  --path=database/migrations/local
php artisan migrate  --path=database/migrations/mongo



php artisan make:command serverDataIntegration
php artisan make:command oracleDataIntegration

php artisan make:factory server/CustomerFactory --model=Server/Customer
php artisan make:factory oracle/CustomerFactory --model=Oracle/Customer
php artisan make:factory mongo/CustomerFactory --model=Mongo/Customer
php artisan tinker
DB::connection('oracle')->getPdo();
App\Models\Server\Customer::factory()->count(1000)->create()
App\Models\Oracle\Customer::factory()->count(1000)->create()
App\Models\Mongo\Customer::factory()->count(1000)->create()

DB::connection('mongodb')->collection('customers')->get();

php artisan integration:sync customer truncate

composer dump-autoload    

