### Order Tracker
This application helps businesses track orders from their customers.

### Setup Instructions
1. Run from project root => composer install
2. Run fom project root => npm install
3. Run from project root => rpm run build
4. Create a mysql database name eg tracker
5. Update the env file with your database credentials
6. Run migration script => php bin/console doctrine:migrations:migrate
7. Run fixture script => php bin/console doctrine:fixtures:load
8. Start server => symfony serve:start
9. Copy an email from the user table with the role you want to be logged in as, use that with the password (secret) to login
