# LARAVEL MULTIPLE DATABASE CONNECTIONS

In this application I used two MySQL databases, one Oracle database and one MongoDB database to merge the table data with each other using the Laravel artisan command handle.

## Getting Started

Here's how to run this application.

### Prerequisites

You need to run MySQL, Oracle and MongoDB on your local server or any other server to run this app properly.

### Usage

#### Preparation of prerequisites

Set up the .env file with your MySQL, Oracle and MongoDB connection using the .env.example file. Then create the appropriate database on each database server or modify your own.
Update composer to download related packages.
You can then execute the following migration commands to create tables in each database.

```shell
:~# php artisan migrate  --path=database/migrations/oracle
:~# php artisan migrate  --path=database/migrations/server
:~# php artisan migrate  --path=database/migrations/local
```

Run below factories in **_tinker_** shell to insert fake data to tables.

```shell
>>> App\Models\Oracle\Customer::factory()->count(1000)->create()
>>> App\Models\Oracle\Product::factory()->count(1000)->create()
>>> App\Models\Local\Invoice::factory()->count(1000)->create()
>>> App\Models\Server\Invoice::factory()->count(1000)->create()
```

#### Run commands

In this application, I created two commands.
One for integrating customer and product data into selected MySQL database(local, server) from the Oracle database using command **_arguments_** and **_options_**.
Another is to integrate invoice data from selected MySQL database(local, server) to MongoDB database using command **_arguments_** and **_options_**.

You can run the following **_arguments_** combinations to merge or truncate and merge one, more or all tables.
The **_--db_** option is mandatory and is used to select the mysql database.

* Oracle Data Integration for MySQL Databases.

```shell
:~# php artisan integration:oracle product,customer --db=local
:~# php artisan integration:oracle product --db=local
:~# php artisan integration:oracle --db=local
:~# php artisan integration:oracle product,customer truncate --db=local
:~# php artisan integration:oracle truncate --db=local
```

* MySQL Data Integration for MongoDB Database.

```shell
:~# php artisan integration:mongo invoice --db=server
:~# php artisan integration:mongo --db=server
:~# php artisan integration:mongo invoice truncate --db=server
:~# php artisan integration:mongo truncate --db=server
```

Please check the code for more information and understanding.

### Other Useful Commands

* Here are some of the **_artisan_** commands used in this project.

```shell
:~# php artisan make:model Local/Customer
:~# php artisan make:migration create_customers_table --table=customers  --path=database/migrations/local
:~# php artisan migrate  --path=database/migrations/local
:~# php artisan make:factory local/CustomerFactory --model=Local/Customer
:~# php artisan make:command OracleDataIntegration
:~# php artisan tinker
```

### Useful File Locations and Files

* `/app/Console/Commands/` - Command(intergration) file location.
* `/config/database.php` - Setup MySQL and MongoDB database connections.
* `/config/oracle.php` - Setup Oracle database connection.

## Author

* **[Ashen Udithamal](https://www.linkedin.com/in/ashenud/)** 



