Link Parser
================================

REQUIREMENTS
------------

The minimum requirement by this application template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this application using the following command:

~~~
php composer.phar global require "fxp/composer-asset-plugin:1.0.0-beta4"
php composer.phar install
~~~

Now you should be able to access the application through the following URL

~~~
http://localhost/
~~~


CONFIGURATION
-------------

### Database

Copy `config/db.php.dist` to `config/db.php`

Copy `config/params.php.dist` to `config/params.php`

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTE:** Yii won't create the database for you, this has to be done manually before you can access it.

Also check and edit the other files in the `config/` directory to customize your application.

Process migrations by `php yii migrate`

Create users by `php yii create-admin mail@mail.com password`
