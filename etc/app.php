<?php 

use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use App\Provider\UserProvider;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

/* Mounting services */
$app->register(new FormServiceProvider());

$app->register(new UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../resources/views',
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
	'db.options' => array(
		'driver'	=> 'pdo_sqlite',
		'path'		=> __DIR__.'/../files/app.db',
		'dbname'	=> 'main',
		'user'		=> 'root',
		'password'	=> ''
	),
));

$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
	    'dashboard' => array(
	        'anonymous' => true,
	        'pattern' => '^/.*$',
	        'form' => array('login_path' => '/login', 'check_path' => '/dashboard/login_check'),
	        'logout' => array('logout_path' => '/dashboard/logout'),
	        'users' => $app->share(function () use ($app) {
				return new UserProvider($app['db']);
			}),

/*	        'users' => array(
	            // raw password is foo
	            'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
	            'guille' => array('ROLE_USER', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
			),
*/
		),
		'unsecured' => array(
			'anonymous' => true,
		),
	)
));

$app['security.access_rules'] = array(
    array('^/dashboard/', 'ROLE_USER'),
    array('^/blog/edit/', 'ROLE_USER'),
    array('^/blog/new', 'ROLE_USER'),
    array('^/page/', 'ROLE_USER'),
    array('^/dashboard/settings', 'ROLE_ADMIN'),
    array('^/dashboard/users', 'ROLE_ADMIN')
);

$app['security.role_hierarchy'] = array(
    'ROLE_ADMIN' => array('ROLE_USER'),
);

$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.domains' => array(),
));

/* Mounting controllers as providers */
$app->mount('/', new App\Controller\MainController());
$app->mount('/database', new App\Controller\CreateSchemaController());
$app->mount('/admin', new App\Controller\AdminController());
$app->mount('/dashboard', new App\Controller\DashboardController());
$app->mount('/blog', new App\Controller\BlogController());

