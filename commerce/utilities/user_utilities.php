<?php

function get_user_by_email($email)
{
  global $pdo;
  $sql = "SELECT * FROM users WHERE email='$email'";
  $statement = $pdo->query($sql);
  $user = $statement->fetch();
  return $user ? true : false;
}

function get_user_by_id($user_id)
{
  global $pdo;
  $sql = "SELECT * FROM users WHERE id='$user_id'";
  $statement = $pdo->query($sql);
  $user = $statement->fetch();
  return $user;
}

function create_user($user)
{
  global $pdo;

  $sql = "INSERT INTO users(first_name, last_name, email, password) VALUES(:first_name, :last_name, :email, :password)";

  $statement = $pdo->prepare($sql);

  $statement->execute([
    ':first_name' => $user['first_name'],
    ':last_name' => $user['last_name'],
    ':email' => $user['email'],
    ':password' => $user['password'],
  ]);

  $user_id = $pdo->lastInsertId();

  $new_user = get_user_by_id($user_id);

  return ["status" => true, "message" => "User created successfully.", "data" => $new_user];
}

function set_user_cart($cart_id, $user_id)
{
  global $pdo;
  $sql = "UPDATE users SET cart_id = '{$cart_id}' WHERE id = '{ $user_id}'";
  $statement = $pdo->query($sql);

  $user_id = $pdo->lastInsertId();

  $user = get_user_by_id($user_id);

  return ["status" => true, "message" => "Cart set successfully.", "data" => $user];
}
