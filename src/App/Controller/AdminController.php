<?php 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

use Silex\Application;
use Silex\ControllerProviderInterface;

class AdminController implements ControllerProviderInterface {

	public function connect(Application $app) {

		$controllers = $app['controllers_factory'];

			$controllers->get('/', function() use($app) {
				return $app['twig']->render('admin/index.html.twig');
			})->bind('admin');

		return $controllers;
	}

}

?>