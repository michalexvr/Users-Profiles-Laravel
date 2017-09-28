# Users-Profiles-Laravel
Sample of User Profiles implemention to use in Laravel. Implemented on Laravel 5.5

### Features

 - Has the controllers, models, middlewares and views needed to manage profile and users
 - Uses the routes declared in the Laravel Route file to provide or deny access at the different sections of your project

### Model schema
The model schema used in this sample is the following:

[![N|Img](https://raw.githubusercontent.com/michalexvr/Users-Profiles-Laravel/master/database/migrations/User-Profiles-Laravel-Schema.png)](https://github.com/michalexvr/Users-Profiles-Laravel/blob/master/database/migrations/User-Profiles-Laravel-Schema.png)

### How to Use

First you need download the project and mount in your public directory
```sh
$ git clone https://github.com/michalexvr/Users-Profiles-Laravel.git
```
Later you have to give access of writing at the storage directory
```sh
chmod -R o+w storage
```
Also you have to modify the .env file with the database configuration
```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dbname
DB_USERNAME=dbuser
DB_PASSWORD=dbpassword
```
Then you have to run the migration and charge de seeds
```sh
$ php artisan migrate:install
$ php artisan migrate
$ php artisan db:seed
```
### Users seeded

|Email|Password|Profile|
|:------------|:------------|:------------|
| admin@system.dom | admin | admin |


### Profiles seeded

|Profile Name|Description|
|:------------|:------------|:------------|
| admin | System Administrator |

And just use it!
