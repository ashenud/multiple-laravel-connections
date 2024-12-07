Laravel Multiple Database Connections
=====================================

This application demonstrates how to use multiple database connections in Laravel, integrating data from two MySQL databases, one Oracle database, and one MongoDB database, all running under Docker.

🚀 Features
---------------
-   **Multiple Database Connections**: Integration with two MySQL databases, one Oracle database, and one MongoDB database.
-   **Docker Setup**: Run the entire application with Docker for streamlined development and deployment.
-   **Seamless Migrations**: Pre configured migrations for each database.
-   **Data Integration Commands**: Commands for merging data between databases.
-   **Modular Architecture**: Organized with separate models and commands for each database type.
-   **Environment Configuration**: Centralized configuration for Docker and database settings.

📦 Prerequisites
---------------
-   You need to have Docker installed on your machine.

🐳 Installation
---------------

1.  **Set up the project:**:

    -   CopyClone the repository.
        ```
        git clone https://github.com/ashenud/multiple-laravel-connections.git
        cd laravelashenud/multiple-laravel-connections
        ```

    -   Copy the `.env.example` file to `.env` and configure your MySQL, Oracle, and MongoDB connection details.
        ```
        cp .env.example .env
        ```
    
2.  **Run Docker Compose**:

    -   Start the Docker services:
        ```
        docker-compose up -d
        ```
3.  **Configure Oracle**:

    -   Access the Oracle service:
        ```
        docker exec -it oracle_server sqlplus / as sysdba @/tmp/init.sql
        ```

🛠️ Laravel & Database Version
---------------

-   **Laravel**: v9
-   **PHP**: 8.3
-   **MySQL**: 5.7
-   **Oracle**: Free 23.5.0.0
-   **MongoDB**: 8

📘 Usage
-----

### Running Integrations

The application provides two main commands for integrating data:

1.  **Oracle Data Integration for MySQL Databases**:

    -   Use the following commands to merge data from Oracle into MySQL databases (`local` or `server`):

        ```
        docker exec -it mlc_backend php artisan integration:oracle product,customer --db=local
        docker exec -it mlc_backend php artisan integration:oracle product --db=local
        docker exec -it mlc_backend php artisan integration:oracle --db=local
        docker exec -it mlc_backend php artisan integration:oracle product,customer truncate --db=local
        docker exec -it mlc_backend php artisan integration:oracle truncate --db=local
        ```

2.  **MySQL Data Integration for MongoDB Database**:

    -   Use these commands to transfer data from MySQL (`local` or `server`) to MongoDB:

        ```
        docker exec -it mlc_backend php artisan integration:mongo invoice --db=server
        docker exec -it mlc_backend php artisan integration:mongo --db=server
        docker exec -it mlc_backend php artisan integration:mongo invoice truncate --db=server
        docker exec -it mlc_backend php artisan integration:mongo truncate --db=server
        ```

### Additional Artisan Commands

Here are some useful Artisan commands used in this project:

-   Creating models:

    ```
    docker exec -it mlc_backend php artisan make:model Local/Customer
    ```

-   Creating migrations:

    ```
    docker exec -it mlc_backend php artisan make:migration create_customers_table --table=customers --path=database/migrations/local
    ```

-   Creating factories:

    ```
    docker exec -it mlc_backend php artisan make:factory local/CustomerFactory --model=Local/Customer
    ```

-   Tinker:

    ```
    docker exec -it mlc_backend php artisan tinker
    ```

🛠️ Configuration Files
-------------------

-   **/config/database.php**: Set up the MySQL and MongoDB connections.
-   **/config/oracle.php**: Set up the Oracle database connection.

🖋️ Author
------

Ashen Udithamal