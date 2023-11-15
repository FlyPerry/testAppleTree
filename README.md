<p align="center">
    <h1 align="center">Мечта Джобса</h1>
    <br>
</p>

Могут быть маленькие баги, не значительные, я особо ревью не делал по коду, но могу 
сказать точно, условия ТЗ все выполнены 

```angular2html
в миграции указан логин и пароль, но я тут продублирую на всякий
polyak:password
Заходить на бэкенд версию, мне было лень разделять.
Тем более в ТЗ было указано
(Установить advanced шаблон Yii2 фреймворка, в backend-приложении
реализовать следующий закрытый функционал (доступ в backend-приложение 
должен производиться только по паролю, сложного разделения прав 
не требуется):
```

Nginx settings:
<p>
/etc/nginx/sites-available/
</p>

```
server {
    listen 80;
    server_name frontend.bigus.kz;

    root /var/www/yii-application/frontend/web;

    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\. {
        deny all;
    }

    error_log /var/log/nginx/yii2_frontend_error.log;
    access_log /var/log/nginx/yii2_frontend_access.log;
}

server {
    listen 80;
    server_name backend.bigus.kz;

    root /var/www/yii-application/backend/web;

    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\. {
        deny all;
    }

    error_log /var/log/nginx/yii2_backend_error.log;
    access_log /var/log/nginx/yii2_backend_access.log;
}

```

nginx.conf

```
user www-data;
worker_processes auto;
pid /run/nginx.pid;
include /etc/nginx/modules-enabled/*.conf;

events {
        worker_connections 768;
        # multi_accept on;
}

http {

        ##

        sendfile on;
        tcp_nopush on;
        types_hash_max_size 2048;
        # server_tokens off;

        # server_names_hash_bucket_size 64;
        # server_name_in_redirect off;

        include /etc/nginx/mime.types;
        default_type application/octet-stream;

        ##
        # SSL Settings
        ##

        ssl_protocols TLSv1 TLSv1.1 TLSv1.2 TLSv1.3; # Dropping SSLv3, ref: POODLE
        ssl_prefer_server_ciphers on;

        ##
        # Logging Settings
        ##

        access_log /var/log/nginx/access.log;
        error_log /var/log/nginx/error.log;

        ##
        # Gzip Settings
        ##

        gzip on;

        # gzip_vary on;
        # gzip_proxied any;
        # gzip_comp_level 6;
        # gzip_buffers 16 8k;
        # gzip_http_version 1.1;
        # gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;

        ##
        # Virtual Host Configs
        ##

        include /etc/nginx/conf.d/*.conf;
        include /etc/nginx/sites-enabled/*;
}
```