Ur1.pl project
--------------

Easy as can.


## Installation

Create a `database.php` file inside the `/config` directory.
Fill it with following code and change the values to fit your configuration:

```php
<?php
  /* Database configuration */
  $dbConfig = new StdClass();

  $dbConfig->hostname = "127.0.0.1";
  $dbConfig->user     = "root";
  $dbConfig->password = "";
  $dbConfig->database = "shortener";
  $dbConfig->port     = 3306;
?>
```

Next, run those two lines in your terminal, in application root:

```bash
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```