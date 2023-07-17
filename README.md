# Notepad Vue

This is a web based application for adding notes and deleting existing notes displayed.

The application has been built using Laravel and Vue.js.

The setup below assumes:
<ul>
    <li>You have NODE installed</li>
    <li>You have PHP installed</li>    
    <li>You have COMPOSER installed</li>
    <li>You have MYSQL installed</li>
    <!-- <li>You have created a database in mysql called 
    <span style="color: gold;">notepad_vue</span>
     installed</li> -->
</ul>

If the above conditions have been met, then continue with the steps below.

To start up the application:

1. Fork and Clone the project</li>
2. Run the following commands to intall dependencies:
```
npm install
composer install
cp ./.env.example ./.env
```
3. Edit the created .env file as per the credentials for your local mysql server
e.g. `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` fields accordingly.
4. Run:
```
php artisan key:generate
```

5. Run the following commands to start the backend server:
```
php artisan migrate
php artisan serve
```
6. Run the following to run the client side server:
```
npm run dev
```
6. Navigate to http://localhost:8000

From there, you will register with the application's interface and start creating and editing notes.
