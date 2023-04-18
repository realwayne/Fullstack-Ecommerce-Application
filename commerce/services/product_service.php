<?php

function get_all_products()
{
  global $pdo;

  $sql = "SELECT categories.name as category_name, categories.id as category_id, products.id, products.name, products.price, products.image FROM `products` INNER JOIN categories ON products.category_id=categories.id";
  $statement = $pdo->query($sql);
  $products = $statement->fetchAll(PDO::FETCH_ASSOC);

  return $products;
}

function get_product_count()
{
  global $pdo;

  $sql = "SELECT COUNT(*) FROM products";
  $statement = $pdo->query(
    $sql
  );
  $count = $statement->fetchColumn();

  return $count;
}

function get_product_by_id($product_id)
{
  global $pdo;

  $sql = "SELECT categories.name as category_name, categories.id as category_id, products.id, products.name, products.price, products.image FROM `products` INNER JOIN categories ON products.category_id=categories.id WHERE products.id = :product_id";

  $statement = $pdo->prepare($sql);
  $statement->bindParam(':product_id', $product_id, PDO::PARAM_INT);
  $statement->execute();
  $product = $statement->fetch(PDO::FETCH_ASSOC);

  return $product;
}

function get_products_by_category_id($category_id)
{

  global $pdo;

  $sql = "SELECT categories.name as category_name, products.id, products.name, products.price, products.image FROM `products` INNER JOIN categories ON products.category_id=categories.id WHERE products.category_id = :category_id";

  $statement = $pdo->prepare($sql);
  $statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
  $statement->execute();
  $products = $statement->fetchAll(PDO::FETCH_ASSOC);

  return $products;
}

function create_product($product)
{
  global $pdo;

  $sql = 'INSERT INTO products(name, price, image, category_id) VALUES(:name, :price, :image, :category_id)';

  $statement = $pdo->prepare($sql);

  $statement->execute([
    ':name' => $product["name"],
    ':price' => $product["price"],
    ':image' => $product["image"],
    ':category_id' => $product["category_id"]
  ]);

  $product_id = $pdo->lastInsertId();

  $product = get_product_by_id($product_id);

  return ["status" => true, "message" => "Product created successfully.", "data" => $product];
}

function delete_product($product_id)
{
  global $pdo;

  $sql = 'DELETE FROM products WHERE id = :product_id';

  $statement = $pdo->prepare($sql);
  $statement->bindParam(':product_id', $product_id, PDO::PARAM_INT);

  if ($statement->execute()) {
    return ["status" => true, "message" => "Product deleted successfully.", "data" => null];
  } else {
    return ["status" => false, "message" => "Error deleting category.", "data" => null];
  }
}

function update_product($new_product)
{
  global $pdo;

  $sql = 'UPDATE products SET name = :name, price = :price, image = :image, category_id = :category_id WHERE id = :id';

  $statement = $pdo->prepare($sql);

  $statement->bindParam(':id', $new_product['id'], PDO::PARAM_INT);
  $statement->bindParam(':name', $new_product['name']);
  $statement->bindParam(':price', $new_product['price']);
  $statement->bindParam(':image', $new_product['image']);
  $statement->bindParam(':category_id', $new_product['category_id']);

  if ($statement->execute()) {
    return ["status" => true, "message" => "Product updated successfully.", "data" => $new_product];
  } else {
    return ["status" => false, "message" => "Error updating product.", "data" => null];
  }
}
