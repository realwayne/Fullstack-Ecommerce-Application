<?php

function count_cart_items($cart_id)
{
  global $pdo;

  $sql = "SELECT COUNT(*) FROM cart_items WHERE cart_id = {$cart_id}";
  $res = $pdo->query($sql);
  $count = $res->fetchColumn();

  return $count;
}

function get_current_signed_in_user()
{
  if (isset($_SESSION['USER'])) {
    return $_SESSION['USER'];
  }
  return null;
}

function update_profile($user_id, $first_name, $last_name, $new_email, $profile_picture)
{
  global $pdo;

  $sql = "UPDATE users SET first_name=:first_name, last_name=:last_name, email=:email, profile_picture=:profile_picture WHERE id=:id";

  $statement = $pdo->prepare($sql);

  $statement->execute([
    ':first_name' => $first_name,
    ':last_name' => $last_name,
    ':email' => $new_email,
    ':id' => $user_id,
    ":profile_picture" => $profile_picture
  ]);

  return ["status" => true, "message" => "Profile updated successfully."];
}

function get_all_customers()
{
  global $pdo;

  $sql = "SELECT * FROM users WHERE role='CUSTOMER'";

  $statement = $pdo->prepare($sql);

  $statement->execute();

  $customer = $statement->fetchAll();

  return $customer;
}

function get_customer_count()
{
  global $pdo;

  $sql = "SELECT COUNT(*) FROM users WHERE role='CUSTOMER'";

  $statement = $pdo->prepare($sql);

  $statement->execute();

  $count = $statement->fetchColumn();

  return $count;
}
