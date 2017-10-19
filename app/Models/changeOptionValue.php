<?php
namespace Models;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class changeOptionValue
{
  //----------------updateSettingsOptionValue----------
  static function updateOptionValue($settingsValue,$request,$app)
  {
    //var_dump($request);
    $option_name = $request->get('option_name');
    $option_value = $request->get('option_value');
    $settingsArray = json_decode($settingsValue, true);
    //var_dump($settingsArray);

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

    $updatedSettingsValue = json_encode($settingsArray, JSON_FORCE_OBJECT);
    return UserSettingsDAO::setSettingsByEmail($app, $request, $updatedSettingsValue);
  }

}
