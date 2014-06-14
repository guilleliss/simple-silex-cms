<?php 

namespace App\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Schema\Table;


class MainController implements ControllerProviderInterface {

	public function connect(Application $app) {

		$controllers = $app['controllers_factory'];

		$controllers->get('/', function() use($app) {
			return $app['twig']->render('index.html.twig');
		})->bind('homepage');

		$app->get('/hello/{name}', function($name) use($app) { 
			return 'Hello '.$app->escape($name); 
		});

		$app->get('/login', function(Request $request) use ($app) {
		    return $app['twig']->render('login.html.twig', array(
		        'error'         => $app['security.last_error']($request),
		        'last_username' => $app['session']->get('_security.last_username'),
		    ));
		});

		return $controllers;

	}

}