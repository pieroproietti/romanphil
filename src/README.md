# romanphil-import

Account
* user git thesi: pieroproietti

# Versioni importazione
* [WordPress 4.7.9](https://woradpress.org/wordpress-4.7.9.zip)
* [woocommerce  3.2.1](https://github.com/woocommerce/woocommerce/archive/3.2.1.zip)


## Database
* dbname: wordress
* user: wordpress
* pass: wordpress

## nella macchina con php
chown -Rf www-data:www-data /var/www/html/


## Importazione
* Creare /var/www/html/romanphil-v3/uploads
* chmod 777 /var/www/html/romanphil-v3/uploads -R
* scompattare wordpress in /var/www/html
* scompattare woocommerce in /var/www/html/wordpress/wp-content/plugin
* git clone http://github.com/pieroproietti/import-romanphil in /var/www/html/WordPress
* installare wordpress ed attivare woocommerce dal browsers
* eseguire un backup del database pulito con nome romanphil-wordpress-clean.sql
* cd /var/www/html/wordpress/import-romanphil
* php import.php

## Plugin and themes
* theme: storefront
é plugin: WooCommerce collapsing categories/ widget: wc-categories

## Dati al 1° marzo 2018

## ngnix

```
location /wordpress/{
  # permalink
  autoindex on;
  try_files $uri $uri/ /wordpress/index.php?$args;
}
```
