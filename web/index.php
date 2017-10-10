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

//-----
$app = new Silex\Application(); // Create the Silex application, in which all configuration is going to go
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../app/Views' // The path to the views/templates,
));

$dbstuff = new Silex\Provider\DoctrineServiceProvider();
$app->register($dbstuff,array());

//--------
$app->get('/', function(){return 'hello';});
$app->get('/optout', function() use($app) {
    return $app['twig']->render('eReminderOptout.html.twig');});
$app->post('/yes', 'Controllers\\OptoutController::optout');
//$app->get('/connect', 'Controllers\\DBConnect::getConnection');

$app->run(); // Start the application, i.e. handle the request
