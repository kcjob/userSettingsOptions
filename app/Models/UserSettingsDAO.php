<?php

namespace Models;

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
  function setSettingsObject($connect, $updatedSettingsValue, $emailAddress)
  {
    $updateQuery = "UPDATE core_users
                    SET settings = ?
                    WHERE email = ?";

    $result = $connect->executeUpdate($updateQuery, array($updatedSettingsValue,$emailAddress));
    return $result;
  }

  //------------GETTER BY EMAIL--------------------
  function getSettingsObject($connect, $emailAddress)
  {
    $sql = "SELECT settings
            FROM core_users
            WHERE email = ?";

    $result = $connect->executeQuery($sql, array($emailAddress));
    $settings = $result->fetch();
    return $settings;
  }

}
