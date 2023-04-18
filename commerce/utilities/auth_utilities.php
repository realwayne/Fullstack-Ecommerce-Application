<?php

function is_authenticated()
{
  return isset($_SESSION['USER']);
}
