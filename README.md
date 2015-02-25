# Symfony skeleton

## Installation

### Install composer

    curl -s http://getcomposer.org/installer | php

### Install symfony skeleton

    composer.phar create-project unoegohh/symfony-standart <target-directory>

## Web Servers
### apache

```
<VirtualHost *:80>
    DocumentRoot {{project path}}/web
    RewriteEngine On
    RewriteCond %{DOCUMENT_ROOT}%{REQUEST_URI} !-f
    RewriteRule ^ /app_dev.php
    
    ServerName {{project url}}
</VirtualHost>
```
Windows apache
```
<VirtualHost *:80>
    DocumentRoot "{{project path}}/web"

    RewriteEngine On 
    RewriteCond %{DOCUMENT_ROOT}%{REQUEST_URI} !-f
    RewriteRule .* /app_dev.php

	<Directory "{{project path}}/web">
		Options FollowSymLinks
		AllowOverride None
		Order allow,deny
		Allow from all
	</Directory>
	
    ServerName {{project url}}
</VirtualHost>
```
### nginx

```
server {
    root /var/www;

    location / {
        location ~ \.php$ {
            fastcgi_pass unix:/var/run/php5-fpm.sock;
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        }

        try_files $uri @backend;
    }

    location @backend {
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root/app_dev.php;
    }
}
```

### Console commands for database

```
php app/console doctrine:database:create
php app/console doctrine:schema:update --force
```
