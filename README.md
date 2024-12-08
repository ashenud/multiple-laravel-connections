Laravel Multiple Database Connections
=====================================

This application demonstrates how to use multiple database connections in Laravel, integrating data from two MySQL databases, one Oracle database, and one MongoDB database, all running under Docker.

🚀 Features
---------------
-   **Multiple Database Connections**: Integration with two MySQL databases, one Oracle database, and one MongoDB database.
-   **Docker Setup**: Run the entire application with Docker for streamlined development and deployment.
-   **Seamless Migrations**: Preconfigured migrations for each database.
-   **Data Integration Commands**: Commands for merging data between databases.
-   **Modular Architecture**: Organized with separate models and commands for each database type.
-   **Environment Configuration**: Centralized configuration for Docker and database settings.

🛠 ️Laravel Multi-Database Integration Toolkit
-------------------------------
This project uses the latest technologies for a seamless development experience. Here are the key versions and their official documentation links:

-   **Laravel**: [9.x](https://laravel.com/docs/9.x) - A robust PHP framework for web artisans, ensuring clean and maintainable code.
    (Will be updated to version 11.x. Reference: [GitHub Issue #4](https://github.com/ashenud/multiple-laravel-connections/issues/4))   
-   **PHP**: [8.3](https://www.php.net/releases/8.3/en.php) - The fastest and most feature-rich version of PHP, offering excellent performance.
-   **MySQL**: [5.7](https://dev.mysql.com/doc/refman/5.7/en/) - A widely-used open-source relational database known for its reliability.
-   **Oracle**: [Free 23.5.0.0](https://docs.oracle.com/en/database/oracle/oracle-database/23/) ️ - The free edition of Oracle Database, ideal for enterprise-grade solutions.
-   **MongoDB**: [v8](https://www.mongodb.com/docs/v8.0/) - A NoSQL database designed for high-performance and scalability.

Each of these tools is optimized for use in this Dockerized environment, providing flexibility and power for handling complex multi-database integrations.

📦 Prerequisites
---------------
-   You need to have Docker installed on your machine.

🐳 Installation
---------------
1.  **Set up the project:**:
    -   Clone the repository.
        ```
        git clone https://github.com/ashenud/multiple-laravel-connections.git
        cd multiple-laravel-connections
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
4.  **Database Setup (Optional)**:
    -   Database migrations will run automatically during the Docker setup, so no manual intervention is required.
    -   However, if you need to run them manually, use the following commands:
        ```
        docker exec -it mlc_backend php artisan migrate --path=database/migrations/oracle
        docker exec -it mlc_backend php artisan migrate --path=database/migrations/server
        docker exec -it mlc_backend php artisan migrate --path=database/migrations/local
        ```
5.  **Seed the databases**:
    -   Use the factory commands to populate tables with dummy data:
        ```
        docker exec -it mlc_backend php artisan tinker
        >>> App\Models\Oracle\Customer::factory()->count(1000)->create()
        >>> App\Models\Oracle\Product::factory()->count(1000)->create()
        >>> App\Models\Local\Invoice::factory()->count(1000)->create()
        >>> App\Models\Server\Invoice::factory()->count(1000)->create()
        ```

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
    docker exec -it mlc_backend php artisan make:factory Local/CustomerFactory --model=Local/Customer
    ```

-   Tinker:

    ```
    docker exec -it mlc_backend php artisan tinker
    ```

🔧️ Configuration Files
-------------------

-   **/config/database.php**: Set up the MySQL and MongoDB connections.
-   **/config/oracle.php**: Set up the Oracle database connection.

### ✍️ Author

**Ashen Udithamal**\
📇 [LinkedIn Profile](https://www.linkedin.com/in/ashenud/)

Connect with me for more innovative solutions and technical insights!