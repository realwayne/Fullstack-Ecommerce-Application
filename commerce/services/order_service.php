<?php

function create_order($customer_id, $card_holder_name, $card_number, $card_expiration, $card_cvv, $sub_total_price, $shipping_fee, $total_price)
{
  global $pdo;

  $sql = 'INSERT INTO orders(customer_id, card_holder_name, card_number, card_expiration, card_cvv, sub_total_price, shipping_fee, total_price) VALUES(:customer_id, :card_holder_name, :card_number, :card_expiration, :card_cvv, :sub_total_price, :shipping_fee, :total_price)';
  $statement = $pdo->prepare($sql);

  $statement->execute([
    ':customer_id' => $customer_id,
    ':card_holder_name' => $card_holder_name,
    ':card_number' => $card_number,
    ':card_expiration' => $card_expiration,
    ':card_cvv' => $card_cvv,
    ':sub_total_price' => $sub_total_price,
    ':shipping_fee' => $shipping_fee,
    ':total_price' => $total_price
  ]);

  $new_order_id = $pdo->lastInsertId();

  return $new_order_id;
}

function get_order($order_id)
{
  global $pdo;

  $sql = 'SELECT * FROM orders WHERE id = :order_id';

  $statement = $pdo->prepare($sql);

  $statement->execute([
    ':order_id' => $order_id
  ]);

  $order = $statement->fetch(PDO::FETCH_ASSOC);

  return $order;
}

function get_all_orders()
{
  global $pdo;

  $sql = 'SELECT * FROM orders INNER JOIN users ON orders.customer_id = users.id';

  $statement = $pdo->prepare($sql);

  $statement->execute();

  $orders = $statement->fetchAll(PDO::FETCH_ASSOC);

  return $orders;
}
