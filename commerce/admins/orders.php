<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/start_session.php");
$pdo = require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/database/connection.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/auth_utilities.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/functions.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/services/order_service.php");
?>

<?php
if (!isAuthenticated() || !isAdmin()) {
  redirect("/commerce/index.php");
}

$orders = get_all_orders();
?>

<?php include("../partials/header.php"); ?>

<?php include("../partials/admins_sidebar.php") ?>

<div>
  <h2>Orders</h2>

  <div class="table-responsive">
    <!--Table-->
    <table class="table table-striped  ">

      <!--Table head-->
      <thead class="table-primary">
        <tr>
          <th>Order Id</th>
          <th>Custorder Name</th>
          <th>Card Holder's Name</th>
          <th>Card Number</th>
          <th>Card Expiration</th>
          <th>Card CVV</th>
          <th>Subtotal Price</th>
          <th>Shipping Fee</th>
          <th>Total Price</th>
        </tr>
      </thead>
      <!--Table head-->

      <!--Table body-->
      <tbody>

        <?php foreach ($orders as $order) : ?>
          <tr>
            <td scope="row"><?php echo ($order["id"]) ?></td>
            <td><?php echo ($order["first_name"]) ?> <?php echo ($order["last_name"]) ?></td>
            <td><?php echo ($order["card_holder_name"]) ?></td>
            <td><?php echo ($order["card_number"]) ?></td>
            <td><?php echo ($order["card_expiration"]) ?></td>
            <td><?php echo ($order["card_cvv"]) ?></td>
            <td><?php echo ($order["sub_total_price"]) ?></td>
            <td><?php echo ($order["shipping_fee"]) ?></td>
            <td><?php echo ($order["total_price"]) ?></td>
          </tr>
        <?php endforeach; ?>

      </tbody>
      <!--Table body-->
    </table>
    <!--Table-->
  </div>
</div>

<?php include("../partials/admins_sidebar_closing.php"); ?>

<?php include("../partials/footer.php"); ?>