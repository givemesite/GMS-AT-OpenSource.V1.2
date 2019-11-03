WinNMP - portable Nginx MariaDB Redis Php development stack for Windows
=========================================================================
A portable, preconfigured, lightweight, fast and stable server stack for developing php mysql applications on windows, based on the excellent webserver Nginx. A lighter alternative to XAMPP and WAMP.



### How to create a new Project

  ![New Project](http://winnmp.wtriple.com/how-tos/1new.png)

 - Open *WinNMP Manager* by clicking the taskbar or desktop icon, then click on New Project icon, choose a project name like myProjectName, hit Enter or click Save Project
 - Accept the *User Account Control* warning about `HostsEditor.exe`. This is required to map the domain name `myProjectName.test` to `localhost`, for testing SEF links and other Nginx rewrite rules.
 - Set the project `Live Url` if any. This should point to the production version of your project, hosted on a remote server.
 - Click `Save` to close the *Edit Project* window
 - In the **Projects** list, click `View Local Virtual Server` to see the default *New WinNMP Project* page.
 - Add project php files in `c:\pathTo\WWW\myProjectName` folder.
 - Use `HeidiSql` or [Adminer](http://localhost/tools/adminer.php?server=localhost&username=root) to create the project's database
 - The default MariaDb(MySql) host is `localhost` with username `root` and no password.
 - The default Redis host is `localhost` port 6379
 - Take a look at [How to create a new LARAVEL project in WinNMP](https://winnmp.wtriple.com/howtoFrameworks#Create-a-new-LARAVEL-Project)
 - Upload or Sync the project files to the remote server, as explained below.

  ![Edit Project](http://winnmp.wtriple.com/how-tos/2edit.png)



#### [Create new PHP projects using various web application frameworks](https://winnmp.wtriple.com/howtoFrameworks)

#### [Configure NGINX virtual server for various PHP Frameworks](https://winnmp.wtriple.com/nginx.php)

#### [How to install Magento 2 on Windows](https://winnmp.wtriple.com/howtoMagento.php)

#### [How to install free SSL Certificates from LetsEncrypt](https://winnmp.wtriple.com/howtoLetsEncrypt.php)



### How to upload files or synchronize your project to a server using WinSCP:

  ![Project Buttons](http://winnmp.wtriple.com/how-tos/5project.png)

 - In the **Projects** list, click *Project Setup* ![Project Setup](http://winnmp.wtriple.com/how-tos/btnProjectSetup.png)
 - Setup the remote connection and Save.
 - Return to the project list and click on `Synchronize` or `Browse` icons. A WinSCP dialog will open.

  ![Sync with WinSCP](http://winnmp.wtriple.com/how-tos/7sync.png)

  ![Browse Files with WinSCP](http://winnmp.wtriple.com/how-tos/10browse.png)




### How to use COMPOSER:

  ![Composer](http://winnmp.wtriple.com/how-tos/4composer.png)

[Composer](https://getcomposer.org/) is a tool for dependency management in PHP used to download and keep updated various PHP frameworks and components. After you created a new project in `c:\pathTo\WWW\myProjectName`, click on `Open Command Prompt` icon, then run commands like:

	composer create-project silverstripe/installer myProjectName 3.1.*

	composer create-project laravel/laravel myProjectName --prefer-dist

	cd myProjectName
	composer require components/jquery 
	composer require components/bootstrap-datetimepicker

	cd myProjectName
	composer create-project symfony/framework-standard-edition c:\pathTo\WWW\myProjectName 2.4.*




### How to change the root directory of a project:

Your project's Nginx settings are stored in `conf\domains.d\myProjectName.conf`. This file`s root directive **is automatically modified** by the *WinNMP manager* for portability.

If you want to use a custom root folder for your project, for example `WWW\myProjectName\public`, you can manually set this root directive and lock it using the comment # locked

		root "C:\PathTo\WWW\myProjectName\public"; # locked




### How to send emails using PHP
WinNMP has 2 options for processing emails sent by PHP's **mail()** function: **mSmtp** and **mailToDisk** (default). To change the option, edit `conf\php.ini` and modify `sendmail_path`:

- For Development use **mailToDisk** (the default):
`sendmail_path = '"C:/WinNMP/bin/php" -n -f "C:/WinNMP/include/tools/mailtodisk.php" --'`
Emails will be saved to `log\mail-XX.eml`

- For Production use **mSmtp**:
`sendmail_path = '"C:/WinNMP/bin/msmtp/msmtp.exe" -C "C:/WinNMP/conf/msmtp.ini" -t'`
You also need to edit `conf\msmtp.ini` in order to configure SMTP server options




### How to allow access from LAN and Internet to your local project:

In the **Projects** list, click ![Project Setup](http://winnmp.wtriple.com/how-tos/btnProjectSetup.png), check `Enable Local Virtual Server`, then Save.

Edit `WinNMP\conf\domains.d\projectName.conf` directly or click on `Edit Nginx Virtual Server` button in the *Edit Project* window
  ![Edit Nginx Local Virtual Server ](http://winnmp.wtriple.com/how-tos/11lan.png)

Modify like this:

	server {
		listen		127.0.0.1:80;
		listen			*:80;

		server_name     projectName.test projectName.com projectName.myDomain.com;

		### Access Restrictions
		allow			all;
		## deny			all;

Now `Kill` Nginx, `Start` Nginx OR `Check Nginx Configuration Syntax`.




### How to add additional local test server names to my project:

  ![Hosts File Editor](http://winnmp.wtriple.com/how-tos/3hosts.png)

You can always use different/multiple server names for your `Local Virtual Server`. Use Hosts File Editor (the third icon) to add extra local server names like:

    127.0.0.1    projectName.dev
    127.0.0.1    projectName.test
    127.0.0.1    www.projectName.xyz

Then Edit `conf\domains.d\projectName.conf` and add

    server_name projectName.dev projectName.test www.projectName.xyz;




### How to add locations

If you want a location like `/phpMyAdmin` to serve files from a directory outside your project (but inside PHP's `open_basedir`), for example `C:/WinNMP/include/phpMyAdmin` you need to edit the Nginx config file:

Edit `WinNMP\conf\domains.d\projectName.conf` to set http://projectName.local/phpMyAdmin

Edit `WinNMP\conf\nginx.conf` to set http://localhost/phpMyAdmin

	server {
		....
		location ~ ^/phpMyAdmin/.*\.php$ {
		        root "C:/WinNMP/include";
		        try_files $uri =404;
		        include     	nginx.fastcgi.conf;
		        fastcgi_pass    php_farm;
				allow			127.0.0.1;
				allow			::1;
				deny			all;
		}
		location ~ ^/phpMyAdmin/ {
		         root "C:/WinNMP/include";
		}
	}

Notice that the root directive lacks `/phpMyAdmin` because Nginx adds the URL path `/phpMyAdmin` to the root path, so the resulting directory is `C:/WinNMP/include/phpMyAdmin`

