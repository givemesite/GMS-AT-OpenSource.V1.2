WinNMP - Nginx MariaDB Redis Php development stack for Windows
=========================================================================
A lightweight, fast and stable server stack for developing php mysql applications on windows, based on the excellent webserver Nginx. A lighter alternative to XAMPP and WAMP.



## How to install Magento 2 on Windows



#### 1. Install WinNMP Stack
 - [Download the latest installer](http://winnmp.wtriple.com/). The installer produces a portable folder.



#### 2. Create a new Magento Project

  ![New Project](http://winnmp.wtriple.com/how-tos/1new.png)

 - Open *WinNMP Manager* by clicking the taskbar or desktop icon, then click on `New Project` icon, choose a project name like `MyMagento`, hit Enter or click `Save Project`.
 - Check `Enable Local Virtual Server`
 - Save the project settings.



#### 3. Download Magento

 - Download the [Magento Archive](https://www.magentocommerce.com/download)
 - Extract files to `WinNMP\WWW\MyMagento`



#### 4. Setup Nginx

 - Edit `WinNMP\conf\domains.d\MyMagento.conf` directly or in WinNMP Projects list > `Project Setup` > `Edit Nginx Local Virtual Server Configuration File` icon.

  ![Edit Nginx Local Virtual Server ](http://winnmp.wtriple.com/how-tos/magento-projectEdit.png)

 - Keep only the first 2 directives ( `listen` and `server_name` ) and replace everything else with:

```
	server {
		#! listen		127.0.0.1:80;
		#! server_name 	MyMagento.test;

		## Magento Vars
		set $MAGE_ROOT "c:/WinNMP/www/MyMagento";
		set $MAGE_MODE default; # or production or developer


		## Access Restrictions
		allow		127.0.0.1;
		deny		all;

		root $MAGE_ROOT/pub; # locked

		index index.php;
		autoindex off;
		charset off;


		add_header 'X-Content-Type-Options' 'nosniff';
		add_header 'X-XSS-Protection' '1; mode=block';

		location /setup {
			root $MAGE_ROOT;
			fastcgi_read_timeout	18000s;
			location ~ ^/setup/index.php {
				include		nginx.fastcgi.conf;
				fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
				fastcgi_pass	php_farm;
			}

			location ~ ^/setup/(?!pub/). {
				deny all;
			}

			location ~ ^/setup/pub/ {
				add_header X-Frame-Options "SAMEORIGIN";
			}
		}

		location /update {
			root $MAGE_ROOT;

			location ~ ^/update/index.php {
				include		nginx.fastcgi.conf;
				fastcgi_split_path_info ^(/update/index.php)(/.+)$;
				fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
				fastcgi_param  PATH_INFO        $fastcgi_path_info;
				fastcgi_pass	php_farm;
			}

			# deny everything but index.php
			location ~ ^/update/(?!pub/). {
				deny all;
			}

			location ~ ^/update/pub/ {
				add_header X-Frame-Options "SAMEORIGIN";
			}
		}

		location / {
			try_files $uri $uri/ /index.php?$args;
		}

		location /pub {
			location ~ ^/pub/media/(downloadable|customer|import|theme_customization/.*\.xml) {
				deny all;
			}
			alias $MAGE_ROOT/pub;
			add_header X-Frame-Options "SAMEORIGIN";
		}

		location /static/ {
			if ($MAGE_MODE = "production") {
				expires max;
			}
			location ~* \.(ico|jpg|jpeg|png|gif|svg|js|css|swf|eot|ttf|otf|woff|woff2)$ {
				add_header Cache-Control "public";
				add_header X-Frame-Options "SAMEORIGIN";
				expires +1w;
				#expires    off;

				if (!-f $request_filename) {
					rewrite ^/static/(.*)$ /static.php?resource=$1 last;
					rewrite ^/static/version\d*/(.*)$ /static.php?resource=$1 last;
				}
			}
			location ~* \.(zip|gz|gzip|bz2|csv|xml)$ {
				add_header Cache-Control "no-store";
				add_header X-Frame-Options "SAMEORIGIN";
				expires    off;

				if (!-f $request_filename) {
					rewrite ^/static/(.*)$ /static.php?resource=$1 last;
					rewrite ^/static/version\d*/(.*)$ /static.php?resource=$1 last;
				}
			}
			if (!-f $request_filename) {
				rewrite ^/static/(.*)$ /static.php?resource=$1 last;
				rewrite ^/static/version\d*/(.*)$ /static.php?resource=$1 last;
			}
			add_header X-Frame-Options "SAMEORIGIN";
		}

		location /media/ {
			try_files $uri $uri/ /get.php?$args;

			location ~ ^/media/theme_customization/.*\.xml {
				deny all;
			}

			location ~* \.(ico|jpg|jpeg|png|gif|svg|js|css|swf|eot|ttf|otf|woff|woff2)$ {
				add_header Cache-Control "public";
				add_header X-Frame-Options "SAMEORIGIN";
				expires +1y;
				try_files $uri $uri/ /get.php?$args;
			}
			location ~* \.(zip|gz|gzip|bz2|csv|xml)$ {
				add_header Cache-Control "no-store";
				add_header X-Frame-Options "SAMEORIGIN";
				expires    off;
				try_files $uri $uri/ /get.php?$args;
			}
			add_header X-Frame-Options "SAMEORIGIN";
		}

		location /media/customer/ {
			deny all;
		}

		location /media/downloadable/ {
			deny all;
		}

		location /media/import/ {
			deny all;
		}

		location ~ cron\.php {
			deny all;
		}

		location ~ (index|get|static|report|404|503)\.php$ {
			try_files $uri =404;

			fastcgi_param  PHP_FLAG  "session.auto_start=off \n suhosin.session.cryptua=off";
			fastcgi_param  PHP_VALUE "memory_limit=256M \n max_execution_time=600";
			fastcgi_read_timeout 600s;
			fastcgi_connect_timeout 600s;
			fastcgi_param  MAGE_MODE $MAGE_MODE;

			include		nginx.fastcgi.conf;
			fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
			fastcgi_pass	php_farm;
		}
	}
```



#### 5. Setup PHP

 - Edit WinNMP\conf\php.ini
 - Comment out or delete:

		open_basedir
		disable_functions
		disable_classes

 - Set:

		max_execution_time = 18000;
		always_populate_raw_post_data = -1
		extension =  php_xsl.dll
		ignore_user_abort = on


#### 7. Apply Changes

- Kill All then restart WinNMP Manager
- or Kill / Start Nginx and Php-Cgi


#### 7. Magento Setup Wizard

 - Open up `app/etc/di.xml` and find the `virtualType name="developerMaterialization"` section. In that section you'll find an item `name="view_preprocessed"`. Modify it by changing the contents from `Magento\Framework\App\View\Asset\MaterializationStrategy\Symlink` to `Magento\Framework\App\View\Asset\MaterializationStrategy\Copy`
 - Browse to `http://MyMagento.test/setup`
 - Optionally, if necesary, On Step 3: Web Configuration, click on *Advanced Options* and uncheck `Apache Rewrites - Use Apache Web Server Rewrites

  ![Magento Setup Wizard Step 3](http://winnmp.wtriple.com/how-tos/magento-Step3.png)

