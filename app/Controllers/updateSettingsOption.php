<?php

namespace UserSettingsOptions;
use \UserSettingsOptions;

class UpdateSettingsOption
{
  static function updateSettingsOptionValue($settingsValue,$option_name, $option_value)
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

    $updatedSettingsValue = json_encode($settingsArray, JSON_FORCE_OBJECT);
    return $updatedSettingsValue;
  }
}
