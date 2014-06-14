<?php 

namespace App\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Schema\Table;

class CreateSchemaController implements ControllerProviderInterface {

	public function connect(Application $app) {

		$controllers = $app['controllers_factory'];

		$controllers->get('/', function() use($app) {
			return 'home database';
		});

		$controllers->get('/schemaPages', function() use($app) { 
			$schema = $app['db']->getSchemaManager();
			if (!$schema->tablesExist('pages')) {
			    $pages = new Table('pages');
			    $pages->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
			    $pages->setPrimaryKey(array('id'));
			    $pages->addColumn('title', 'string', array('length' => 100));
			    $pages->addColumn('content', 'string', array('length' => 1000));
			    $pages->addUniqueIndex(array('title'));
			    $pages->addColumn('link', 'string', array('length' => 255));

			    $pages->addColumn('created', 'date');
			    $pages->addColumn('modified', 'date', array('notnull' => false));
			    $pages->addColumn('active', 'boolean');

			    $schema->createTable($pages);

			    $app['db']->insert('pages', array(
			      'title' => 'index',
			      'content' => 'Welcome to another Silex website',
			      'link' => '/',
			      'created' => get_object_vars(new \DateTime('now'))['date'],
			      'active' => true
			    ));

			    $app['db']->insert('pages', array(
			      'title' => 'about',
			      'content' => 'About this website',
			      'link' => '/about',
			      'created' => get_object_vars(new \DateTime('now'))['date'],
			      'active' => true
			    ));

			    $app['db']->insert('pages', array(
			      'title' => 'contact',
			      'content' => 'Contact information',
			      'link' => '/contact',
			      'created' => get_object_vars(new \DateTime('now'))['date'],
			      'active' => true
			    ));
			}

			return 'schema created';			
		});

		$controllers->get('/schemaUsers', function() use($app) { 
			$schema = $app['db']->getSchemaManager();
			if (!$schema->tablesExist('users')) {
			    $users = new Table('users');
			    $users->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
			    $users->setPrimaryKey(array('id'));
			    $users->addColumn('username', 'string', array('length' => 32));
			    $users->addUniqueIndex(array('username'));
			    $users->addColumn('email', 'string', array('length' => 255));
			    $users->addColumn('password', 'string', array('length' => 255));
			    $users->addColumn('roles', 'string', array('length' => 255));

			    $users->addColumn('created', 'date');
			    $users->addColumn('modified', 'date', array('notnull' => false));
			    $users->addColumn('active', 'boolean');

			    $schema->createTable($users);

			    $app['db']->insert('users', array(
			      'username' => 'user',
			      'password' => '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg==',
			      'roles' => 'ROLE_USER',
			      'created' => get_object_vars(new \DateTime('now'))['date'],
			      'active' => true,
			      'email' => 'user@mail.com'
			    ));

			    $app['db']->insert('users', array(
			      'username' => 'admin',
			      'password' => '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg==',
			      'roles' => 'ROLE_ADMIN',
			      'created' => get_object_vars(new \DateTime('now'))['date'],
			      'active' => true,
			      'email' => 'admin@mail.com'
			    ));
			}

			return 'schema created';			
		});

		$controllers->get('/schemaPosts', function() use($app) { 
			$schema = $app['db']->getSchemaManager();
			if (!$schema->tablesExist('posts')) {
			    $posts = new Table('posts');
			    $posts->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
			    $posts->setPrimaryKey(array('id'));

			    $posts->addColumn('title', 'string', array('length' => 255));
			    $posts->addUniqueIndex(array('title'));

			    $posts->addColumn('content', 'string', array('length' => 255));
			    $posts->addColumn('user_id', 'integer', array('unsigned' => true));

			    $posts->addColumn('created', 'date');
			    $posts->addColumn('modified', 'date', array('notnull' => false));
			    $posts->addColumn('active', 'boolean');

			    $posts->addForeignKeyConstraint($schema->listTableDetails('users'), array("user_id"), array("id"), array("onUpdate" => "CASCADE"));

			    $schema->createTable($posts);
			}

			return 'schema created';			
		});

		return $controllers;

	}

}