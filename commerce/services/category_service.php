<?php

function get_all_categories()
{
  global $pdo;

  $sql = "SELECT * FROM categories";
  $statement = $pdo->query($sql);
  $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

  return $categories;
}

function get_category_count()
{
  global $pdo;

  $sql = "SELECT COUNT(*) FROM categories";
  $statement = $pdo->query(
    $sql
  );
  $count = $statement->fetchColumn();

  return $count;
}

function get_category_by_id($category_id)
{
  global $pdo;

  $sql = 'SELECT *  FROM categories WHERE id = :category_id';

  $statement = $pdo->prepare($sql);
  $statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
  $statement->execute();
  $category = $statement->fetch(PDO::FETCH_ASSOC);

  return $category;
}

function create_category($category_name)
{
  global $pdo;

  $sql = 'INSERT INTO categories(name) VALUES(:name)';

  $statement = $pdo->prepare($sql);

  $statement->execute([
    ':name' => $category_name
  ]);

  $category_id = $pdo->lastInsertId();

  $category = get_category_by_id($category_id);

  return ["status" => true, "message" => "Category created successfully.", "data" => $category];
}

function delete_category($category_id)
{
  global $pdo;

  $sql = 'DELETE FROM categories WHERE id = :category_id';

  $statement = $pdo->prepare($sql);
  $statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);

  if ($statement->execute()) {
    return ["status" => true, "message" => "Category deleted successfully.", "data" => null];
  } else {
    return ["status" => false, "message" => "Error deleting category.", "data" => null];
  }
}

function update_category($category_id, $new_category)
{
  global $pdo;

  $publisher = [
    'publisher_id' => 1,
    'name' => 'McGraw-Hill Education'
  ];

  $sql = 'UPDATE categories SET name = :name WHERE id = :category_id';

  $statement = $pdo->prepare($sql);

  $statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
  $statement->bindParam(':name', $new_category);

  if ($statement->execute()) {
    return ["status" => true, "message" => "Category updated successfully.", "data" => ["id" => $category_id, "name" => $new_category]];
  } else {
    return ["status" => false, "message" => "Error updating category.", "data" => null];
  }
}
