Simple Silex CMS
====================


About
---------------------
Attempt to build a basic CMS with blog functionallity based on [Silex PHP microframework](http://silex.sensiolabs.org).  

Requirements
---------------------
* PHP 5.4*
* Mysql
* Composer

*Older versions of PHP would work but at least 5.4 is required for built-in webserver (for development). See [Silex documentation](http://silex.sensiolabs.org/doc/web_servers.html) on that.

Packages
---------------------
* Twig as template system.
* Doctrine for database access.
* Twitter Boostrap 3.1.
* Form/validator component for building forms and validation.
* Security component for authorization and authentication.

Check [Silex service providers documentation](http://silex.sensiolabs.org/documentation) for info.


Usage
---------------------

# Without vagrant

	git clone https://github.com/guilleliss/simple-silex-cms.git path/
	cd path/
	curl -s http://getcomposer.org/installer | php
	php composer.phar install
	php -S localhost:8000 -t web web/index.php

Then just open [http://localhost:8000](http://localhost:8080).

# With vagrant
Comming soon.

TODO
---------------------
* Installation with database initialization.
* Page CRUD.
* Better user managment, authorization and authentication.
* Add vagrant environment with all the required resources.