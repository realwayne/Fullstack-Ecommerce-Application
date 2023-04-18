<?php
$pdo = require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/database/connection.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/start_session.php");
?>
<?php include './partials/header.php'; ?>

<body>
  <?php include 'partials/navbar.php'; ?>

  <div class="px-4 py-5 my-5 text-center">
    <!-- <img class="d-block mx-auto mb-4" src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
    <h1 class="display-5 fw-bold">Wayne Shop</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">Shop men's clothing, shirts, pants, jeans, polos, jackets, & more online | Nationwide Shipping ✓ Cash On Delivery ✓ Cashback ✓ 30 Days Free ..</p>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <?php if (!is_authenticated()) : ?>
          <a href="/commerce/register.php" type="button" class="btn btn-primary btn-lg px-4 gap-3">Register</a>
        <?php endif ?>
        <?php if (is_authenticated()) : ?>
          <a href="/commerce/cart.php" type="button" class="btn btn-primary btn-lg px-4 gap-3">Cart</a>
        <?php endif ?>
        <a href="/commerce/products.php" type="button" class="btn btn-outline-secondary btn-lg px-4">Products</a>
      </div>
    </div>
  </div>

  <div class="container px-4 py-5" id="featured-3">
    <h2 class="pb-2 border-bottom text-center">Products we're Selling.</h2>
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
      <div class="feature col">
        <div class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-2 mb-3">
          <img class="img-thumbnail border-0" src="https://img.freepik.com/free-vector/stand-out-concept-illustration_114360-5525.jpg?w=740&t=st=1670600810~exp=1670601410~hmac=647248f4e5e77e65511e36cc485170ddeb6b1738ca9de5de60adae08d8fe9b75" alt="Men">
        </div>
        <h3 class="fs-2">Mens</h3>
        <p>Shop men's clothing, shirts, pants, jeans, polos, jackets, & more online | Nationwide Shipping ✓ Cash On Delivery ✓ Cashback ✓ 30 Days Free ..</p>
        <a href="/commerce/products.php?category_id=1" class="btn btn-primary">
          View
        </a>
      </div>
      <div class="feature col">
        <div class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-2 mb-3">
          <img class="img-thumbnail border-0" src="https://img.freepik.com/free-vector/flat-hand-drawn-confident-female-entrepreneurs_52683-55364.jpg?w=740&t=st=1670600759~exp=1670601359~hmac=2e3b17f0a65b803cddbe32260c337e2cabbfec7fb66fe1f8073ce58445556eb1" alt="Women">
        </div>
        <h3 class="fs-2">Womens</h3>
        <p>Shop stylish Women's Clothing like blazers, sweaters, skirts, cardigans, & more online | Nationwide Shipping ✓ Cash On Delivery ✓ 30 Days Free ...</p>
        <a href="/commerce/products.php?category_id=2" class="btn btn-primary">
          View
        </a>
      </div>
      <div class="feature col">
        <div class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-2 mb-3">
          <img class="img-thumbnail border-0" src="https://img.freepik.com/free-vector/basketball-player-with-ball-sportsman-vector-cartoon-illustration-muscular-man-cap-professional-athlete-sport-trainer-handsome-strong-guy-with-smile-isolated-orange-background_107791-8214.jpg?w=740&t=st=1670600877~exp=1670601477~hmac=8635086096c9006f11236bd659149d35f47c3d64fb1200f312a6378a45cd5f2c" alt="Kids">
        </div>
        <h3 class="fs-2">Kids</h3>
        <p>Shop Kids Clothes for Boys and Girls Online on ZALORA Philippines and enjoy ✓ Nationwide Shipping ✓ Cash On Delivery ✓ 30 Days Free Returns.</p>
        <a href="/commerce/products.php?category_id=3" class="btn btn-primary">
          View
        </a>
      </div>
    </div>

    <?php include("./partials/footer_section.php"); ?>
  </div>

</body>

<?php include './partials/footer.php'; ?>