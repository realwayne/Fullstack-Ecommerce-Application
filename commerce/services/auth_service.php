<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/user_utilities.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/services/cart_service.php");

function registerUser($firstname, $lastname, $email, $password)
{
  global $pdo;

  $user = get_user_by_email($email);

  if ($user) {
    return ["status" => false, "message" => "User with that email already exist.", "data" => null];
  }

  $create_user_response = create_user([
    "first_name" => $firstname,
    "last_name" => $lastname,
    "email" => $email,
    "password" => $password,
  ]);

  $create_user_cart_response = create_new_cart($create_user_response["data"]["id"]);

  if ($create_user_cart_response["status"]) {
    return ["status" => true, "message" => "User registered successfully.", "data" => $create_user_response["data"]];
  } else {
    return ["status" => false, "message" => "Error registering user.", "data" => null];
  }
}

function loginUser($email, $password)
{
  global $pdo;

  $sql = "SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}'";
  $statement = $pdo->query($sql);
  $user = $statement->fetch();

  if ($user) {
    $_SESSION["USER"] = $user;
    return ["status" => true, "message" => "Success logging in.", "data" => $user];;
  }
  return ["status" => false, "message" => "Invalid email or password.", "data" => null];
}

function changePassword($user_id, $old_password, $new_password)
{
  global $pdo;

  $sql = "SELECT * FROM users WHERE id = '{$user_id}' AND password = '{$old_password}'";
  $statement = $pdo->query($sql);
  $user = $statement->fetch();

  if ($user) {
    $sql = "UPDATE users SET password = '{$new_password}' WHERE id = '{$user_id}'";
    $statement = $pdo->query($sql);
    return ["status" => true, "message" => "Password changed successfully.", "data" => null];
  }
  return ["status" => false, "message" => "Invalid old password.", "data" => null];
}
