<?php

function redirect($url)
{
  header("Location: $url");
}

function redirectToRoot()
{
  redirect("{$_SERVER['DOCUMENT_ROOT']}/commerce/index.php");
}

function isAuthenticated()
{
  return isset($_SESSION["USER"]) ? true : false;
}

function isAdmin()
{
  return $_SESSION["USER"]["role"] === "ADMIN" ? true : false;
}
