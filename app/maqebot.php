<?php
  include_once('./utilities.php');
  include_once('./Clesses/Robot.php');

  if ($argv && isset($argv[1])) {
    $params = strval($argv[1]);
    $robot = new Robot();
    return $robot->command($params);
  }

  // echo 'Hello, World';