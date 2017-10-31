<?php
namespace Models;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SettingsOptoutString
{
  //----------------updateSettingsOptionValue----------
  function updateOptoutValue($settingsObject)
  {
    $option_name = 'optout';
    $option_value = '1';
    $settingsArray = json_decode($settingsObject, true);

    if(array_key_exists($option_name, $settingsArray))
    {
        $settingsArray[$option_name] = $option_value;
    }
    $updatedSettingsObject = json_encode($settingsArray, JSON_FORCE_OBJECT);
    //var_dump($updatedSettingsValue);
    //UserSettingsDAO::setSettingsOptout($app, $request, $updatedSettingsValue);
    return $updatedSettingsObject;
  }

}
