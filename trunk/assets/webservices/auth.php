<?php
 header('Content-type: application/json');
  include('../functions/functions.php');
  $data = json_decode(file_get_contents('php://input'));
  $auth=basic_authentication($authname, $authpw);
  print_r($auth);exit;
  if($auth)
  {
    echo "working";
  }
  else
  {
    echo "error";
  }
  exit;


?>