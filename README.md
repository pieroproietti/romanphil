# romanphil
Sito di ecommerce realizzato in wordpress, in versione docker.

# Attenzione
Non viene salvato su git l'intero sito, ma solo la customizzazione.

Il database, viene creato nella cartella ./volumes/db, mentre il sorgente
directory ./srv viene impostato come /var/www/html dei container.

## docker
* ``` ./bin/dup  --build ``` docker-compose up -d --build
* ``` ./bin/ddown``` docker-compose down
* ``` ./bin/dexec``` docker exec -it [mysql|php|ngnix] bash

I container sono quattro:
* mysql
+ php
* ngnix
* phpmyadmin

Account
* user git thesi: pieroproietti

# Versioni wp da utilizzare per l'importazione
* [WordPress 4.7.9](https://woradpress.org/wordpress-4.7.9.zip)
* [woocommerce  3.2.1](https://github.com/woocommerce/woocommerce/archive/3.2.1.zip)


## Database
* dbname: wordress
* user: wordpress
* pass: wordpress

## Nella macchina con php
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

## ngnix

```
location /wordpress/{
  # permalink
  autoindex on;
  try_files $uri $uri/ /wordpress/index.php?$args;
}
```

URL: http://www.romanphil.com/gestione/img/prodotti/big/97natalebfsmom.gif
Product id: 2500
Description: foglietto natale
FILE_IMG: PATH_IMPORT_IMAGEShttp://www.romanphil.com/gestione/img/prodotti/big/97natalebfsmom.gif
URL: http://www.romanphil.com/gestione/img/prodotti/big/97natalebfsmom.gif
HTML:  <img src='http://127.0.0.1/wordpress/wp-content/uploads/2018/03/97natalebfsmom.gif' alt='foglietto natale' />

Fatal error: Allowed memory size of 134217728 bytes exhausted (tried to allocate 32 bytes) in /var/www/html/import/simple_html_dom.php on line 1561
