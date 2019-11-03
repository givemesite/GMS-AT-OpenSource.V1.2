WinNMP - Configure NGINX virtual server for various PHP Frameworks
===============================================================


In the *WinNMP Manager* window, go to `Project Setup`, check `Enable Local Virtual Server`, then Save.

Edit `WinNMP\conf\domains.d\projectName.conf` directly or go to `Project Setup` and click on `Edit Nginx Local Virtual Server Configuration File` icon.

  ![Edit Nginx Local Virtual Server](http://WinNMP.wtriple.com/how-tos/11lan.png)





### Anchor Nginx configuration:

```
	location / {
		try_files $uri $uri/ /index.php;
	}
```


### Bolt Nginx configuration:

```
	location / {
		try_files $uri $uri/ /index.php?$query_string;
	}

	location ~* /thumbs/(.*)$ {
		try_files $uri $uri/ /index.php?$query_string;
	}

	location ~* /async/(.*)$ {
		try_files $uri $uri/ /index.php?$query_string;
	}

	location /app/classes/upload {
		try_files $uri $uri/ /app/classes/upload/index.php?$query_string;
	}


	# If you set a custom branding path, you will need to change '/bolt/' here to match
	location ~* /bolt/(.*)$ {
		try_files $uri $uri/ /index.php?$query_string;
	}

	location ~* \.(?:ico|css|js|gif|jpe?g|png|ttf|woff)$ {
		#access_log off;
		expires 30d;
		add_header Pragma public;
		add_header Cache-Control "public, mustrevalidate, proxy-revalidate";
	}


	location /app {
		deny all;
	}
	 
	location ~ /vendor {
		deny all;
	}
 
	location ~* \.(db|yml|twig|htaccess|htpasswd)$ {
		return 444;
	}
```


### CakePHP Nginx configuration:

```
	location / {
		try_files $uri $uri/ /index.php?$args;
	}
```


### CodeIgniter Nginx configuration:

```
         location / {
                # Check if a file or directory index file exists, else route it to index.php.
                try_files $uri $uri/ /index.php;
        }
```


### Drupal Nginx configuration:

```
	# This matters if you use drush
	location = /backup {
		deny all;
	}

	## Very rarely should these ever be accessed outside of your lan
	location ~* \.(txt|log)$ {
		allow 127.0.0.1;
		deny all;
	}

	location ~ \..*/.*\.php {
		return 403;
	}


	location / {
		## This is cool because no php is touched for static content
		try_files $uri $uri/ @rewrite;
		# expires max;
	}

	location @rewrite {
		## Some modules enforce no slash (/) at the end of the URL
		## Else this rewrite block wouldn&#39;t be needed (GlobalRedirect)
		rewrite ^/(.*)$ /index.php?q=$1;
	}


	 location ~ ^/sites/.*/files/imagecache/ {
		try_files $uri @rewrite;
	}

	location ~* \.(js|css|png|jpg|jpeg|gif|ico)$ {
		# expires max;
		log_not_found off;
	}
```


### FatFreeFramework Nginx configuration:

```
    location / {
        index index.php index.html index.htm;
        try_files $uri /index.php?$query_string;
    }
```


### Joomla Nginx configuration:

```
	# Support Clean (aka Search Engine Friendly) URLs
	location / {
		try_files $uri $uri/ /index.php?$args;
	}

	# deny running scripts inside writable directories
	location ~* /(images|cache|media|logs|tmp)/.*\.(php|pl|py|jsp|asp|sh|cgi)$ {
		return 403;
		error_page 403 /403_error.html;
	}

	# caching of files 
	location ~* \.(ico|pdf|flv)$ {
		expires 1y;
	}

	location ~* \.(js|css|png|jpg|jpeg|gif|swf|xml|txt)$ {
		expires 14d;
	}
```


### Laravel Nginx configuration:

```
	location / {
		try_files $uri $uri/ /index.php?$query_string;
	}
```


### LiteCart Nginx configuration:

```
	error_page 403 /error_document?code=403;
	error_page 404 /error_document?code=404;
	error_page 410 /error_document?code=410;


	location / {
		try_files $uri $uri/ /index.php;			
	}


	location ~* ^/cache/_cache_ {			
		deny all;
	}

	location /data {
		deny all;
	}

	location ~* ^/vqmod/.*\.(xml|cache|log)$ {
		return 444;
	}
```


### Magento Nginx configuration:

```
see http://WinNMP.wtriple.com/howtoMagento.php - How to install Magento 2 on Windows under Nginx
```


### OpenCart Nginx configuration:

```
	# Add trailing slash to */admin requests.
	rewrite /admin$ $scheme://$host$uri/ permanent;

	location / {
		# This try_files directive is used to enable SEO-friendly URLs for OpenCart.              
		server_tokens off;
		client_max_body_size 10m;
		client_body_buffer_size 128k;
		try_files $uri @opencart;
	}

	location @opencart {
		rewrite ^/(.+)$ /index.php?_route_=$1 last;
	}

	location /admin {
		index index.php;
	}
			
	rewrite ^/sitemap.xml$ /index.php?route=feed/google_sitemap last;
	rewrite ^/googlebase.xml$ /index.php?route=feed/google_base last;
	rewrite ^/download/(.*) /index.php?route=error/not_found last;
```


### osTicket Nginx configuration:

```
	rewrite ^/api/(.*)$ /api/http.php?q=/$1 last;
	rewrite ^/apps/(.*)$ /apps/dispatcher.php?q=/$1 last;
	rewrite ^/pages/(.*)$ /pages/index.php?q=/$1 last;
	rewrite ^/scp/apps/(.*)$ /scp/apps/dispatcher.php?q=/$1 last;

	### if osTicket is installed in a subdirectory like /tickets, 
	### modify the lines above like in this example:
	#rewrite ^/tickets/api/(.*)$ /tickets/api/http.php?q=/$1 last;

	### You also need to patch include/class.osticket.php 
	### Line ~366:  
	#	function get_path_info() {
	#		if (isset($_GET['q'])) return $_GET['q'];


	# For ajax requests
	rewrite ^(.*/.*)\.php/(.*)$ $1.php?q=/$2 last;		

	location /include {		
		deny	all;
	}
	location /scp/css {
		expires 14d;
	}
	location /scp/js {
		expires 14d;
	}
```


### Pico Nginx configuration:

```
	location / {
		try_files $uri $uri/ /index.php;
	}
```


### Respond Nginx configuration:

```
	#Remove PHP extension from requests
	location / {
		if (!-e $request_filename){
			rewrite ^/api/.* /api/dispatch.php?$query_string last;
			rewrite ^(.*)$ /$1.php;
		}

		error_page 400 401 402 403 404 500 = /page/error;
		
		try_files $uri $uri/ /index.php?$query_string;
	}
```


### Symfony Nginx configuration:

```
	location / {
		# try to serve file directly, fallback to app.php
		try_files $uri /app.php$is_args$args;
	}
```


### Wordpress Nginx configuration:

```
	rewrite /wp-admin$ $scheme://$host$uri/ permanent;
	if (!-e $request_filename) {
		rewrite ^.+/?(/wp-.*) $1 last;
		rewrite ^.+/?(/.*\.php)$ $1 last;
		rewrite ^(.+)$ /index.php?q=$1 last;
	}
```


### Yii Nginx configuration:

```
	location / {
		# Redirect everything that isn't a real file to index.php
		try_files $uri $uri/ /index.php?$args;
	}

	# uncomment to avoid processing of calls to non-existing static files by Yii
	#location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
	#	try_files $uri =404;
	#}	
	#error_page 404 /404.html;	

	location ~ /\.(ht|svn|git) {
		deny all;
	}
```