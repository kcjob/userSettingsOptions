<?php
require_once __DIR__.'/../vendor/autoload.php'; // Add the autoloading mechanism of Composer

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Connection;


//----- initialze Application ---
$app = new Silex\Application(); // Create the Silex application, in which all configuration is going to go
$app['debug'] = true; //--- Set debug mode --

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../app/Views' // The path to the views/templates,
));

$app->register(new Silex\Provider\DoctrineServiceProvider(),array(
            'db.options' => array (
            'driver'    => 'mysqli',
            'host'      => 'localhost',
            'dbname'    => '',
            'user'      => '',
            'password'  => '')
            ));
//echo '<pre>' . var_export($app['db']->error(), true) . '</pre>';

//--------
$app->get('/', function() use($app) {
    return $app['twig']->render('DefaultOptoutForm.html.twig');
});
$app->post('/optout', 'Controllers\\OptoutController::getUserByEmail');

$app->run(); // Start the application, i.e. handle the request
