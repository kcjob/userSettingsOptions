<?php
namespace Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OptoutController
{

  //--------------getUserByEmail---------------
  public function getUserByEmail(Application $app, Request $request)
  {
    $emailAddress = $request->get('emailAddy');
    if(!$emailAddress)
    {
      return $app->redirect('/weboptout');
    }
    $sql = "SELECT settings
            FROM core_users
            WHERE email = ?"; //dfimiarz@ccny.cuny.edu

    $result = $app['db']->prepare($sql);
    if(!$result){
      //echo "Prepare failed: (" . $connectToDb->errno . ") " . $connectToDb->error;
      throw new \Exception('getSettingsByEmail Querry failed');
      die();
    }
    $result->bindValue('1', $emailAddress);
    $result->execute();
    $userSettings = $result->fetch();
    $settingsValue = $userSettings['settings'];
    return $settingsValue;

    //$app['twig']->render('defaultView.html.twig',$params);
  } //getUserByEmail

  //----------------updateSettingsOptionValue----------
  public function updateSettingsOptionValue()
  {
      //print_r($settingsValue);
      $settingsArray = json_decode($settingsValue, true);
      //print_r($settingsArray);

      if(array_key_exists($option_name, $settingsArray))
      {
        if($option_name == 'optout')
        {
          $settingsArray[$option_name] = $option_value;
        }
      }
      /*
       This is where the new key/value option goes if it does not exist
       in the format {$option_name:$option_value}
      */

      $updatedSettingsValue = json_encode($settingsArray, JSON_FORCE_OBJEC);
      return $updatedSettingsValue;
  }

}
