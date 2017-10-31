<?php

namespace Models;

use Models\UserSettingsDAO;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UserSettingsDAO
{
  /**
  * Data Access Object
  * Because static methods are callable without an instance of the object created,
  * the pseudo-variable $this is not available inside the method declared as static.
  */
  private $option_name;
  private $user_id;

  function __construc()
  {

  }


  //------------SETTER by EMAIL--------------------
  function setSettingsObject($app, $updatedSettingsValue, $emailAddress)
  {
    $updateQuery = "UPDATE core_users
                    SET settings = ?
                    WHERE email = ?";

    $result = $app['db']->executeUpdate($updateQuery, array($updatedSettingsValue,$emailAddress));
    if(empty($result))
    {
      var_dump($result);
      // Set flash message and return redirect
      $app['session']->getFlashBag()->add('updated', 'You have already been unsubscribed');
      return $app->redirect('/web/emailNotify');
      //throw new \Exception('setSettingsByEmail Querry failed');
      //die();
    }
  }

  //------------GETTER BY EMAIL--------------------
  function getSettingsObject($app, $emailAddress)
  {
    $sql = "SELECT settings
            FROM core_users
            WHERE email = ?";

    $result = $app['db']->executeQuery($sql, array($emailAddress));
    $settings = $result->fetch();
    //var_dump($settings);

    if(empty($settings)){
      $app['session']->getFlashBag()->add('wrongEmail', 'Please enter a correct Email Address');
      return $app->redirect('/weboptout/web');
    }

    $settingsObject = $settings['settings'];
    return $settingsObject;
    //OptionValueManager::updateOptionValue($app, $request, $settingsValue);
  }

}
