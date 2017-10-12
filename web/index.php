<?php
require_once __DIR__.'/../vendor/autoload.php'; // Add the autoloading mechanism of Composer

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Schema\Table;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\HttpKernel\Debug\ErrorHandler;
use Symfony\Component\HttpKernel\Debug\ExceptionHandler;

//--- Set Error Handling --
ini_set('display_errors', 0);
error_reporting(-1);
//ErrorHandler::register();
//ExceptionHandler::register();

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
            'dbname'    => 'scidiv',
            'user'      => 'test',
            'password'  => 'test')
            ));
//var_dump($app['db']);
//$em = GetMyEntityManager();
//--------
//$app->get('/', function(){return 'Hello';});
$app->get('/', function() use($app) {
    return $app['twig']->render('DefaultOptoutForm.html.twig');});
$app->post('/optout', 'Controllers\\OptoutController::optout');
$app->get('/connect', 'Controllers\\DBConnect::testConnection');
//$app->get('/confirm', 'Controllers\\OptoutControler::confirm');

$app->run(); // Start the application, i.e. handle the request
