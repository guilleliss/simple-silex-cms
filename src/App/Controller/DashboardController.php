<?php 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

use Silex\Application;
use Silex\ControllerProviderInterface;

class DashboardController implements ControllerProviderInterface {

	public function connect(Application $app) {

		$controllers = $app['controllers_factory'];

		$controllers->get('/', function() use($app) {
			return $app['twig']->render('dashboard/index.html.twig');
		})->bind('dashboard');

		$controllers->get('/posts', function() use($app) {
			$sql = "SELECT * FROM posts";
			$posts = $app['db']->fetchAll($sql);

			return $app['twig']->render('dashboard/posts.html.twig', array(
				'posts' => $posts
			));
		})->bind('dashboard/posts');

		$controllers->get('/users', function() use($app) {
			$sql = "SELECT * FROM users";
			$users = $app['db']->fetchAll($sql);

			return $app['twig']->render('dashboard/users.html.twig', array(
				'users' => $users
			));
		})->bind('dashboard/users');	

		$controllers->get('/pages', function() use($app) {
			$sql = "SELECT * FROM pages";
			$pages = $app['db']->fetchAll($sql);

			return $app['twig']->render('dashboard/pages.html.twig', array(
				'pages' => $pages
			));
		})->bind('dashboard/pages');

		$controllers->get('/profile', function() use($app) {
			return $app['twig']->render('dashboard/profile.html.twig');
		})->bind('profile');

/*
		$controllers->get('signup', function() use($app) {
			return $app['twig']->render('index.html.twig');
		})->bind('signup');

		$controllers->get('settings', function() use($app) {
			return $app['twig']->render('index.html.twig');
		})->bind('settings');

*/

		return $controllers;
	}

}

?>