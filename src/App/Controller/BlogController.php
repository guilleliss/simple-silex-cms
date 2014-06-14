<?php 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Silex\Application;
use Silex\ControllerProviderInterface;

class BlogController implements ControllerProviderInterface {

	public function connect(Application $app) {

		$controllers = $app['controllers_factory'];

		$controllers->get('/', function() use($app) {
			$sql = "SELECT posts.id, username, posts.title, posts.content,
				users.id, posts.created FROM posts, users WHERE posts.user_id = users.id
				ORDER BY posts.created desc";

			$posts = $app['db']->fetchAll($sql);

//			print_r($posts);

			return $app['twig']->render('blog/index.html.twig', array(
				'posts' => $posts
			));
		})->bind('blog');

		$controllers->get('/{id}', function ($id) use ($app) {    
			$sql = "SELECT posts.id, username, posts.title, posts.content, users.id, 
				posts.created FROM posts, users WHERE posts.user_id = users.id
				AND posts.id = ?
				ORDER BY posts.created desc";
			$post = $app['db']->fetchAssoc($sql, array($id));

			return $app['twig']->render('blog/post.html.twig', array(
				'post' => $post,
			));

		})->bind('post')
		->assert('id', '\d+');

		$controllers->match('/new', function (Request $request) use ($app) {
			// some default data for when the form is displayed the first time
			$data = array(
				'title' => 'Post title',
				'content' => 'Post content',
			);

			$form = $app['form.factory']->createBuilder('form', $data)
				->add('title', 'text', array(
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))))
				->add('content', 'textarea', array(
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('max' => 1000)))))
				->getForm();

			$form->handleRequest($request);

			if ($form->isValid()) {
				$data = $form->getData();

				//Get the user id
				$token = $app['security']->getToken();
				$userLogged = $token->getUser();
				$username = $userLogged->getUsername();

				$sql = "SELECT * FROM users where username = ?";
				$user = $app['db']->fetchAssoc($sql, array($username));

				// Set the current date
				$created = get_object_vars(new \DateTime('now'))['date'];

				$app['db']->insert('posts', array(
					'title' => $data['title'],
					'content' => $data['content'],
					'created' => $created,
					'user_id' => $user['id'],
					'active' => true
				));

				$sql = "SELECT * FROM posts WHERE title = ? and content = ?";
				$post = $app['db']->fetchAssoc($sql, array($data['title'], $data['content']));

				// redirect somewhere
				return $app->redirect('/blog/'.$post['id']);
			}

			// display the form
			return $app['twig']->render('blog/edit.html.twig', array('form' => $form->createView()));
		})->bind('new');

		$controllers->match('/edit/{id}', function (Request $request, $id) use ($app) {
			$sql = "SELECT * FROM posts WHERE id = ?";
			$post = $app['db']->fetchAssoc($sql, array($id));

			$form = $app['form.factory']->createBuilder('form', $post)
				->add('id', 'hidden')
				->add('title', 'text', array(
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))))
				->add('content', 'textarea', array(
				'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('max' => 1000)))))
				->getForm();

			$form->handleRequest($request);

			if ($form->isValid()) {
				$data = $form->getData();

				$app['db']->update('posts', array('title' => $data['title'], 'content' => $data['content']), array('id' => $data['id']));

				return $app->redirect('/blog/'.$data['id']);
			}

			return $app['twig']->render('blog/edit.html.twig', array('form' => $form->createView(), 'post' => $post ));
		})->bind('edit')
		->assert('id', '\d+');

		return $controllers;
	}

}

?>