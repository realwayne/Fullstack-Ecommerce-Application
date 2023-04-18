<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/start_session.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/cart_utilities.php");

function create_new_cart($customer_id)
{
  global $pdo;

  $sql = 'INSERT INTO carts(id) VALUES(:customer_id)';

  $statement = $pdo->prepare($sql);

  $statement->execute([
    ':customer_id' => $customer_id
  ]);

  $pdo->lastInsertId();

  return ["status" => true, "message" => "Cart created successfully.", "data" => null];
}

function add_cart_item($cart_id, $product_id, $quantity)
{
  global $pdo;

  $sql = 'INSERT INTO cart_items(cart_id, product_id, quantity) VALUES(:cart_id, :product_id, :quantity)';

  $statement = $pdo->prepare($sql);

  $statement->execute([
    ':cart_id' => $cart_id,
    ':product_id' => $product_id,
    ':quantity' => $quantity
  ]);

  $new_cart_item_id = $pdo->lastInsertId();
  $new_cart_item = get_cart_item($new_cart_item_id);

  return ["status" => true, "message" => "Cart item added successfully.", "data" => $new_cart_item];
}

function remove_cart_item($cart_item_id)
{
  global $pdo;

  $sql = 'DELETE FROM cart_items WHERE id = :cart_item_id';

  $statement = $pdo->prepare($sql);

  $statement->execute([
    ':cart_item_id' => $cart_item_id
  ]);

  return ["status" => true, "message" => "Cart item removed successfully.", "data" => null];
}

function remove_all_cart_items($cart_id)
{
  global $pdo;

  $sql = 'DELETE FROM cart_items WHERE cart_id = :cart_id';

  $statement = $pdo->prepare($sql);

  $statement->execute([
    ':cart_id' => $cart_id
  ]);

  return ["status" => true, "message" => "All cart items removed successfully.", "data" => null];
}

function get_cart_items($cart_id)
{
  global $pdo;

  $sql = 'SELECT cart_items.id as cart_item_id, cart_items.quantity as cart_item_quantity, products.id as product_id, products.name as product_name, products.price as product_price, products.category_id as product_category, products.image as product_image FROM cart_items INNER JOIN products ON cart_items.product_id = products.id WHERE cart_items.cart_id = :cart_id';

  $statement = $pdo->prepare($sql);

  $statement->execute([
    ':cart_id' => $cart_id
  ]);

  $cart_items = $statement->fetchAll();

  return ["status" => true, "message" => "Cart items retrieved successfully.", "data" => $cart_items];
}

function get_cart_item($cart_item_id)
{
  global $pdo;

  $sql = 'SELECT * FROM cart_items WHERE id = :cart_item_id';

  $statement = $pdo->prepare($sql);

  $statement->execute([
    ':cart_item_id' => $cart_item_id
  ]);

  return ["status" => true, "message" => "Cart item retrieved successfully.", "data" => $statement->fetch()];
}

function update_cart_item($cart_item_id, $product_id, $quantity)
{
  global $pdo;

  $sql = 'UPDATE cart_items SET product_id = :product_id, quantity = :quantity WHERE id = :cart_item_id';

  $statement = $pdo->prepare($sql);

  $statement->execute([
    ':cart_item_id' => $cart_item_id,
    ':product_id' => $product_id,
    ':quantity' => $quantity
  ]);

  return ["status" => true, "message" => "Cart item updated successfully.", "data" => null];
}

function get_cart($cart_id)
{
  global $pdo;

  $sql = 'SELECT * FROM carts WHERE id = :cart_id';

  $statement = $pdo->prepare($sql);

  $statement->execute([
    ':cart_id' => $cart_id
  ]);

  return ["status" => true, "message" => "Cart retrieved successfully.", "data" => $statement->fetch()];
}

function update_cart($cart_id, $customer_id)
{
  global $pdo;

  $sql = 'UPDATE carts SET customer_id = :customer_id WHERE id = :cart_id';

  $statement = $pdo->prepare($sql);

  $statement->execute([
    ':cart_id' => $cart_id,
    ':customer_id' => $customer_id
  ]);

  return ["status" => true, "message" => "Cart updated successfully.", "data" => null];
}

function delete_cart($cart_id)
{
  global $pdo;

  $sql = 'DELETE FROM carts WHERE id = :cart_id';

  $statement = $pdo->prepare($sql);

  $statement->execute([
    ':cart_id' => $cart_id
  ]);

  return ["status" => true, "message" => "Cart deleted successfully.", "data" => null];
}
