<?php

function count_cart_items($cart_id)
{
  global $pdo;

  $sql = "SELECT COUNT(*) FROM cart_items WHERE cart_id = {$cart_id}";
  $res = $pdo->query($sql);
  $count = $res->fetchColumn();

  return $count;
}
