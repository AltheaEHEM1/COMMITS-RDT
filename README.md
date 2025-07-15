# PRMS (Patient Record Management System)

## System Description
[pending description of PRMS]

---

## Project Setup
### Step 1: Clone the Repository
- To begin, clone the PRMS repository from GitHub:
    ```bash
    git clone https://github.com/AltheaEHEM1/COMMITS-RDT.git
    ```

### Step 2: Set Up the Database (MySQL)
This project specifically uses MySQL as the database management system. Follow the steps below to set up the database:
1. Open your MySQL client (e.g., MySQL Workbench, phpMyAdmin, or the MySQL command line).
2. Create a new database (schema) named `prms`.
    - Using the MySQL command line:
        ```bash
        CREATE DATABASE prms;
        ```
    - In MySQL Workbench or phpMyAdmin, select "Create New Database" and name it `prms`.
3. Ensure the database user credentials (username and password) have the necessary privileges to access and modify the prms database.


### Step 3: Configure the Environment
- Rename the `.env.example` file to `.env` by simply right-click and rename or by running the following command in Terminal:
    ```cmd
    ren .env.example .env
    ```
- Uncomment and update the following database settings in the `.env` file to match your environment:
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=prms
    DB_USERNAME=root
    DB_PASSWORD=
    ```
    *Note: The default `DB_PORT` is `3306`. Adjust it if your setup uses a different port. Same goes for `DB_USERNAME` and `DB_PASSWORD`.*

### Step 4: Install Dependencies
- Install the required Laravel dependencies using Composer:
    ```bash
    composer install
    ```
- Install vite for TailwindCSS:
   ```bash
    npm install
   ```

### Step 5: Generate the Application Key
- Generate a new application key to secure your installation:
    ```bash
    php artisan key:generate
    ```

### Step 6: Set Up the Database
- Run the migrations to create the necessary database tables:
    ```bash
    php artisan migrate
    ```
- (Optional) Seed the database with initial data:
    ```bash
    php artisan db:seed
    ```
    php artisan migrate:fresh --seed

### Step 7: Start the Development Server
- Start the Laravel development server:
    ```bash
    php artisan serve
    ```
    npm run dev

---

### If you are having trouble installing npm
- Open windows powershell as administrator:
    ```bash
    Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
    ```

### Access the Application
- Once the server is running, open your browser and navigate to:
    ```bash
    http://127.0.0.1:8000
    ```

---

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
