# Test atrinium

## Requiriments 
- PHP 8.2.12 or mayor (You also need that php be a global command in the terminal)
- Composer 2.8.6

## Steps to run the project
1) For use the project run composer install
2) Change in .env 
### This is for the /convert endpoint
- FIXER_ACCESS_KEY="ACCESS_KEY" #With an access_key from https://mailtrap.io/es/
### This is for the mail notifications
- MAIL_MAILER = smtp
- MAIL_HOST = MAILTRAP_HOST
- MAIL_PORT = MAILTRAP_PORT
- MAIL_USERNAME = MAILTRAP_USERNAME
- MAIL_PASSWORD = MAILTRAP_PASSWORD
3) Run php artisan migrate --seed
4) Press enter to "Would you like to create it? (yes/no) [yes]"
5) Run php artisan serve
6) Go to POSTMAN and import the file Laravel.postman_collection.json
7) Run login with the user that you want to test (all password are the word "password")
- super_admin@example.com
- admin@example.com
- company_manager@example.com
- user@example.com
8) Run any other request
