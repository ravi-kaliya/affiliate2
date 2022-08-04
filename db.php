<?php

  $host = 'localhost';
  $user = 'traveliqcp_wp750';
  $password = 'pi6S[U.4L8';
  $dbname = 'traveliqcp_wp750';

  //set DSN -  Database Source Name
  $dsn = 'mysql:host=' . $host .'; dbname=' . $dbname;

  try {
    //create a PDO instance
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";

  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }

?>

