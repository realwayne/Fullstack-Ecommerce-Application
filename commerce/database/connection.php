<?php
require('configurations.php');

function connect($host, $db, $user, $password)
{
  $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

  try {
    return new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

return connect($host, $db, $user, $password);
