<?php
namespace Controllers;

use Models\UserSettingsDAO;
use Models\SettingsOptoutString;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OptoutController
{
  public function optoutManager(Application $app, Request $request)
  {
    $emailAddress = $request->get('emailAddy');
    if(!$emailAddress)
    {
      # Set flash message and return redirect
      $app['session']->getFlashBag()->add('missing', 'Please enter a valid Email Address');
      return $app->redirect('/weboptout/web');
    }
    $settingsObject = UserSettingsDAO::getSettingsObject($app, $emailAddress);
    $updatedSettingsValue = SettingsOptoutString::updateOptoutValue($settingsObject);
    $newSettingsObject = UserSettingsDAO::setSettingsObject($app, $updatedSettingsValue, $emailAddress);
    //var_dump($updatedSettingsValue);
    return $app['twig']->render('thankYou.html.twig');
  }

}
