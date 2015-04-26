Potentiate Store
===================

This project is a solution to the Potentiate Store. It is developed in php5.5. 

Latest Stable Version - 1.0.0

## Prerequisites

- PHP 5.5 or later
- Nginx or Apache
- Twig Templating Engine

## Demo

[View Website](https://potentiate-store.herokuapp.com/)

## Apache Config 

```sh
<VirtualHost *:80>
    ServerName potentiate.local

    DocumentRoot /opt/web/potentiate-store
    DirectoryIndex index.php
    ErrorLog /var/log/apache2/potentiate.log
    CustomLog /var/log/apache2/potentiate-access.log combined

    <Directory "/opt/web/potentiate-store/web">
        AllowOverride None
#        Allow from All
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php [QSA,L]
    </Directory>
</VirtualHost>

```

## Enhancements and Recommendations

Here are some recommendations that I would do if I had more time

- Store Items data in a database, which means each item will have an unique id. This will make the application more robust.
- More validation is required on Form input.
- Add Unit and Integration tests using phpUnit and behat. I would especially write unit tests to test the PackageItemsProcessors class.
- Store all the javascript and bootstrap assets on a local CDN Server.
- Verify business logic as the evenly distributed isn't working for all combinations.