### Order Tracker
This application helps businesses track orders from their customers.

### Setup Instructions
1. Run from project root => composer install
2. Run fom project root => npm install
3. Run from project root => rpm run build
4. Create a mysql database name eg tracker
5. Update the env file with your database credentials
6. Run migration script => php bin/console doctrine:migrations:migrate
7. Start server => symfony serve:start