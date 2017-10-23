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
  static function setSettingsByEmail($app, $request, $updatedSettingsValue)
  {
    $emailAddress = $request->get('emailAddy');

    $updateQuery = "UPDATE core_users
                    SET settings = ?
                    WHERE email = ?";

    $result = $app['db']->executeUpdate($updateQuery, array($updatedSettingsValue,$emailAddress));

    if(!$result)
    {
      # Set flash message and return redirect
      $app['session']->getFlashBag()->add('updated', 'You have already been unsubscribed');
      return $app->redirect('/weboptout/web');
      //throw new \Exception('setSettingsByEmail Querry failed');
      //die();
    }
    return $app['twig']->render('thankYou.html.twig');
  }

  //------------SETTER by ID--------------------
  static function setSettingsById($connectToDb, $settingsObject, $user_id)
  {
    $UpdateOptionQuery = "UPDATE core_users
                          SET settings = ?
                          WHERE id = ?";

    $OptionQueryResult = $connectToDb->prepare($UpdateOptionQuery);
    if(!$OptionQueryResult){
      throw new \Exception('setSettingsById Querry failed');
      die();
    }

    $OptionQueryResult -> execute();
	  $OptionQueryResult -> bind_param('ss', $settingsObject, $user_id);
    $OptionQueryResult -> execute();
  }


  //------------GETTER BY ID--------------------
  static function getSettingsByUser_id($connectToDb, $user_id)
  {
    $optionByUser_idQuery = "SELECT settings
                    FROM core_users
                    WHERE id = ?";

    $queryResult = $connectToDb->prepare($optionByUser_idQuery);
    if(!$queryResult){
      throw new \Exception('getSettingsByUser_id Querry failed');
      die();
    }
    $queryResult -> bind_param('i', $user_id);
    $queryResult -> execute();
    $queryResult -> bind_result($settings);

    try{
      $queryResult -> fetch();
      return  $settings; //$this -> parseJson($settings, $option_name);
    } catch (Exception $e) {
      $log->error($e->getMessage());
      echo "Database connection failed\r\n";
      die();
    }

  }

  //------------GETTER BY EMAIL--------------------
  static function getSettingsByEmail(Application $app, Request $request)
  {
    $emailAddress = $request->get('emailAddy');
    $sql = "SELECT settings
            FROM core_users
            WHERE email = ?";

    $result = $app['db']->prepare($sql);

    $result->bindValue('1', $emailAddress);
    $result->execute();

    if(!($result->fetch())){
      # Set flash message and return redirect
      $app['session']->getFlashBag()->add('wrongEmail', 'Please enter a correct Email Address');
      return $app->redirect('/weboptout/web');
      //echo "Prepare failed: (" . $connectToDb->errno . ") " . $connectToDb->error;
      //throw new \Exception('getSettingsByEmail Querry failed');
      //die();
    }

    $userSettings = $result->fetch();
    $settingsValue = $userSettings['settings'];
    //var_dump($settingsValue);

    return changeOptionValue::updateOptionValue($settingsValue,$request,$app);
  }

  //------------------GETTER ALL SETTINGS-----------------
  static function getAllsettings($connectToDb)
  {
    /**
      * NOTE: fetch_array does not work with prepare()
      *  Returns an array of the ids who opted out
      * @param type $connectToDb
      * @return Array $settings
      */
    $usersAndSettings = [];
    $qry = "SELECT id,settings FROM core_users limit 3";

    $qryResult = $connectToDb->query($qry); //prepare($qry);
    if(!$qryResult){
        throw new \Exception('$GetAllSettings Querry failed');
      die();
    }
    while($row = $qryResult -> fetch_array(MYSQLI_ASSOC)){
      $settings[] = $row; //An array of assoc arrays
    }
    return $settings;
  }


  //----------------
  static function parseJson($settings, $option_name)
  {
    if($settings == ""){
      return false;
    }
    $settingsOptionArray = json_decode($settings, TRUE);
    foreach($settingsOptionArray as $key => $value){
      if($settingsOptionArray[$option_name])
        return true;
    }
  }

}
