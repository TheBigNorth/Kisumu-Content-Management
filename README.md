# WordPress Network Starter

## Why?

This starter is installable using [Composer](https://getcomposer.org/). Also, as you may know, working with WordPress Multisite Network is a bit
fiddly. For one, you can't simply configure it solely using wp-config in one go. 

I aim to take some of the difficulty 
out of setting up a WordPress Multisite, especially for local development.

## What is it?

## Pre-requisites

* [Composer](https://getcomposer.org/)

  You can of course, simply download the zip file of this project. However, the dependencies are managed through Composer.

* Development environment (MAMP, WAMP, Docker, Vagrant)

    * PHP 5.6+ (I just use 7.1+ now)
    
    * Apache or Nginx

      The instructions I've included in this readme are designed to work with Nginx. However, WordPress has Apache [.htaccess](https://codex.wordpress.org/Create_A_Network#Step_2:_Allow_Multisite) instructions in their codex.

    * MySQL
    
    * Ubuntu (or another Linux distro. Windows still works too)

## Nginx Configurations

For a normal WordPress installation:

```conf
server {
    listen 80 default_server;
	listen [::]:80 default_server;

    server_name _;

    error_log /var/log/nginx/error.log warn;

    root /var/www/html/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        try_files $uri =404;
        include /etc/nginx/fastcgi.conf;
        fastcgi_pass unix:/run/php/php7.1-fpm.sock;
    }
}
```

For a multisite installation:

```conf
server {
    listen 80 default_server;
	listen [::]:80 default_server;

    server_name _;

    error_log /var/log/nginx/error.log warn;

    root /var/www/html/public/;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    # Rewrite multisite '.../wp-.*' and '.../*.php'.
    if (!-e $request_filename) {
        rewrite /wp-admin$ $scheme://$host$uri/ permanent;
        rewrite ^/[_0-9a-zA-Z-]+(/wp-.*) /wordpress$1 last;
        rewrite ^/[_0-9a-zA-Z-]+(/.*\.php)$ /wordpress$1 last;

        rewrite ^/(wp-.*.php)$ /wordpress/$1 last;
        rewrite ^/(wp-(content|admin|includes).*) /wordpress/$1 last;
    }

    location ~ \.php$ {
        try_files $uri =404;
        include /etc/nginx/fastcgi.conf;
        fastcgi_pass unix:/run/php/php7.1-fpm.sock;
    }

}
```

## RoadMap

- [ ] Step-by-step manual installation instructions
- [ ] Automate local development of the WordPress Multisite Starter with Docker.
- [ ] Add a step-by-step guide for continuous integration based on one way of doing things