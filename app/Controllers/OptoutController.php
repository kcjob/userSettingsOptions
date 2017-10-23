<?php
namespace Controllers;

use Models\UserSettingsDAO;
use Models\changeOptionValue;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OptoutController
{

  public function getUserByEmail(Application $app, Request $request)
  {
    $emailAddress = $request->get('emailAddy');
    if(!$emailAddress)
    {
      return $app->redirect('/weboptout');
    }
    return UserSettingsDAO::getSettingsByEmail($app, $request);
  } //getUserByEmail

}
