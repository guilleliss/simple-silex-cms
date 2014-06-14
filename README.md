Simple Silex CMS
====================


About
---------------------
Attempt to build a basic CMS with blog functionallity based on [Silex PHP microframework](http://silex.sensiolabs.org).  

Requirements
---------------------
* PHP 5.4*
* Composer

*Older versions of PHP would work but at least 5.4 is required for built-in webserver (for development). See [Silex documentation](http://silex.sensiolabs.org/doc/web_servers.html).

Usage
---------------------

	git clone https://github.com/guilleliss/simple-silex-cms.git path/
	cd path/
	curl -s http://getcomposer.org/installer | php
	php composer.phar install
	php -S localhost:8000 -t web web/index.php

Then just open [http://localhost:8080](http://localhost:8080).

TODO
---------------------
* Installation with database initialization.
* Page CRUD.
* Better user managment, authorization and authentication.