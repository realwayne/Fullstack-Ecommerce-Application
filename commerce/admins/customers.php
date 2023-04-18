<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/start_session.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/functions.php");
$pdo = require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/database/connection.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/services/user_service.php");
?>
<?php

if (!isAuthenticated() || !isAdmin()) {
  redirect("/commerce/index.php");
}


$customers = get_all_customers();

?>
<?php include("../partials/header.php"); ?>

<?php include("../partials/admins_sidebar.php") ?>

<div>
  <h2>Customers</h2>

  <div class="table-responsive">
    <!--Table-->
    <table class="table table-striped  ">

      <!--Table head-->
      <thead class="table-primary">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Profile</th>
        </tr>
      </thead>
      <!--Table head-->

      <!--Table body-->
      <tbody>

        <?php foreach ($customers as $customer) : ?>
          <tr>
            <th scope="row"><?php echo ($customer["id"]) ?></th>
            <td><?php echo ($customer["first_name"]) ?> <?php echo ($customer["last_name"]) ?></td>
            <th scope="row"><?php echo ($customer["email"]) ?></th>
            <td><img style="display: block; width: 2.5rem; height: 2.5rem;" src="<?php echo ($customer["profile_picture"]) ?>" alt="<?php echo ($customer["first_name"]) ?>"></td>
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