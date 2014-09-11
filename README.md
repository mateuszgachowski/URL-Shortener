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

Database schema:

```sql
# Dump of table links
# ------------------------------------------------------------

DROP TABLE IF EXISTS `links`;

CREATE TABLE `links` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url_shortened` varchar(2000) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

Next, run those two lines in your terminal, in application root:

```bash
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```