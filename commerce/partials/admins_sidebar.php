<?php
$current_active_page = basename($_SERVER['PHP_SELF'], ".php");
?>

<body>
  <?php include("../partials/navbar.php"); ?>
  <div class="container">
    <div class="row">
      <div class="d-flex flex-column flex-shrink-0 rounded rounded-5 border-primary shadow-lg bg-body p-3" style="width: 280px;">
        <ul class="nav nav-pills flex-column mb-auto">
          <li>
            <a href="/commerce/admins/index.php" class="nav-link <?php echo ($current_active_page === "index" ?  "bg-primary text-light" : "") ?>">
              <i class="fa-solid fa-house fs-4"></i>
              Dashboard
            </a>
          </li>
          <li>
            <a href="/commerce/admins/products.php" class="nav-link <?php echo ($current_active_page === "products" ?  "bg-primary text-light" : "") ?>">
              <i class="fa-solid fa-cart-shopping fs-4"></i>
              Products
            </a>
          </li>
          <li>
            <a href="/commerce/admins/categories.php" class="nav-link <?php echo ($current_active_page === "categories" ?  "bg-primary text-light" : "") ?>">
              <i class="fa-solid fa-filter fs-4"></i>
              Categories
            </a>
          </li>
          <li>
            <a href="/commerce/admins/customers.php" class="nav-link <?php echo ($current_active_page === "customers" ?  "bg-primary text-light" : "") ?>">
              <i class="fa-regular fa-user fs-4"></i>
              Customers
            </a>
          </li>
          <li>
            <a href="/commerce/admins/orders.php" class="nav-link <?php echo ($current_active_page === "orders" ?  "bg-primary text-light" : "") ?>">
              <i class="fa-solid fa-arrow-down-wide-short fs-4"></i>
              Orders
            </a>
          </li>
        </ul>
      </div>
      <div class="col p-5 py-4 rounded rounded-5  ">