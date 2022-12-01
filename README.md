-- run command "composer run post-root-package-install"(This will create the required .env file)
-- run command "composer run post-create-project-cmd"(This sets the APP_KEY value in your .env file)
-- update .env file with your db configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

-- update .env file with your Mail configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=578
MAIL_USERNAME=@gmail.com
MAIL_PASSWORD=
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

-- run command "php artisan migrate"(This will run the db migration files and create all necessary table. If you haven't created your db before running this command, you'd be asked if it should be created for you. Type yes then enter)
