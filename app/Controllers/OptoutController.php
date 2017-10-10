<?php
namespace Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OptoutController
{
  public function optout(Application $app, Request $request)
  {
    $msg = $request->get('emailAddy');
    //$params = ["message" => $msg];
      return $msg;
      //$app['twig']->render('defaultView.html.twig',$params);

  }

}
