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
    $connect = $app['db'];
    $emailAddress = $request->get('emailAddy');
    if(!$emailAddress)
    {
      # Set flash message and return redirect
      $app['session']->getFlashBag()->add('missing', 'Please enter a valid Email Address');
      return $app->redirect('/weboptout/web');
    }
    $settings = UserSettingsDAO::getSettingsObject($connect, $emailAddress);
    if(!$settings){
      $app['session']->getFlashBag()->add('wrongEmail', 'Please enter a correct Email Address');
      return $app->redirect('/weboptout/web');
    }
    $settingsObject = $settings['settings'];

    $updatedSettingsValue = SettingsOptoutString::updateOptoutValue($settingsObject);

    try{
      $newSettingsObject = UserSettingsDAO::setSettingsObject($connect, $updatedSettingsValue, $emailAddress);
    }catch (\Exception $e){
      $app['monolog']->error($e->getMessage());
      return 'Oops, something happen!!... Please inform core facilities that your attempt
      to unsubscribe was unsuccessful!!';
    }
    if(!$newSettingsObject)
    {
      // Set flash message and return redirect
      $app['session']->getFlashBag()->add('updated', 'You have already been unsubscribed');
      return $app->redirect('/weboptout/web');
    }
    return $app['twig']->render('thankYou.html.twig');
  }

}
