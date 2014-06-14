<?php 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

use Silex\Application;
use Silex\ControllerProviderInterface;

class UserController implements ControllerProviderInterface {

	public function connect(Application $app) {

		$controllers = $app['controllers_factory'];

		$controllers->get('/', function() use($app) {
			return $app['twig']->render('index.html.twig');
		})->bind('admin');

		$controllers->get('signup', function() use($app) {
			return $app['twig']->render('index.html.twig');
		})->bind('signup');

		$controllers->get('settings', function() use($app) {
			return $app['twig']->render('index.html.twig');
		})->bind('settings');

		$controllers->get('login', function() use($app) {
			return $app['twig']->render('index.html.twig');
		})->bind('login');

		$controllers->get('logout', function() use($app) {
			return $app['twig']->render('index.html.twig');
		})->bind('logout');


		return $controllers;
	}

}

?>