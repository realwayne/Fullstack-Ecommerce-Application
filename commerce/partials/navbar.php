<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/auth_utilities.php");
// require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/count_cart_utility.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/services/user_service.php");
?>

<?php

$navbar_user = get_current_signed_in_user();
$current_active_page = basename($_SERVER['PHP_SELF'], ".php");

$cart_items_count = null;
if (!isset($_SESSION["USER"])) {
  $cart_items_count = 0;
} else {
  $cart_items_count = count_cart_items($navbar_user["id"]);
}


?>

<div class="container">
  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <a href="/commerce/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
      <h4>Wayne Shop</h4>
    </a>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
      <li><a href="/commerce/" class="rounded nav-link px-2 link-dark <?php echo ($current_active_page == "index" ? "bg-primary text-white" : "") ?>
      ">Home</a></li>
      <li><a href="/commerce/products.php" class="rounded nav-link px-2 link-dark <?php echo ($current_active_page == "products" ? "bg-primary text-white" : "") ?>">Products</a></li>
      <li><a href="/commerce/about.php" class="rounded nav-link px-2 link-dark <?php echo ($current_active_page == "about" ? "bg-primary text-white" : "") ?>">About</a></li>

      <?php if (is_authenticated()) : ?>

        <li><a href="/commerce/cart.php" class="rounded nav-link px-2 link-dark position-relative <?php echo ($current_active_page == "cart" ? "bg-primary text-white" : "") ?>">Cart
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
              <?php echo ($cart_items_count) ?>
            </span>
          </a></li>

      <?php endif ?>
    </ul>

    <div class="col-md-3 text-end">
      <?php if (!is_authenticated()) : ?>
        <a href="/commerce/login.php" type="button" class="btn btn-outline-primary me-2">Login</a>
        <a href="/commerce/register.php" type="button" class="btn btn-primary">Sign-up</a>
      <?php endif ?>

      <?php if (is_authenticated()) : ?>
        <div class="dropdown">
          <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-mdb-toggle="dropdown" aria-expanded="false">
            <img style="display: inline-block; width: 2rem; height: 2rem; border-radius: 50%; margin-right: .5rem;" src="<?php echo ($navbar_user["profile_picture"]) ?>" alt="<?php echo ($navbar_user["first_name"]) ?>">
            <?php echo ($navbar_user["first_name"]) ?> <?php echo ($navbar_user["last_name"]) ?>
          </a>

          <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
            <li><a href="/commerce/profile.php" class="dropdown-item">Profile</a></li>
            <?php if ($navbar_user["role"] === "ADMIN") : ?>
              <li><a href="/commerce/admins/index.php" class="dropdown-item">Admin Dashboard</a></li>
            <?php endif ?>
            <li>
              <hr class="dropdown-divider" />
            </li>
            <li><a href="/commerce/logout.php" class="text-white text-bg-success dropdown-item  ">Logout</a></li>
          </ul>
        </div>
      <?php endif ?>

    </div>
  </header>
</div>