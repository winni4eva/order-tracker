### Order Tracker
This application helps businesses track orders from their customers.

### Setup Instructions
1. Create a mysql database name eg tracker
2. Update the env file with your database credentials
3. Run migration script => php bin/console doctrine:migrations:migrate
4. Start server => symfony serve:start