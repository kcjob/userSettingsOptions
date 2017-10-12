<?php
namespace Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OptoutController
{
  public function optout(Application $app, Request $request)
  {
    $emailAddress = $request->get('emailAddy');
    if(!$emailAddress)
    {
      return 'no email address entered';
    }
    $sql = "SELECT settings
            FROM core_users
            WHERE email = ?";

    $result = $app['db']->prepare($sql);
    if(!$result){
      //echo "Prepare failed: (" . $connectToDb->errno . ") " . $connectToDb->error;
      throw new \Exception('getSettingsByEmail Querry failed');
      die();
    }
    $result->bindValue(1, $emailAddress);
    $result->execute();
    $result-dump();
      return $emailAddress;

      //$app['twig']->render('defaultView.html.twig',$params);
  }

}
