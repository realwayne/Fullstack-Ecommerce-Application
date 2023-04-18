<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/start_session.php");
$pdo = require("{$_SERVER['DOCUMENT_ROOT']}/commerce/database/connection.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/auth_utilities.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/functions.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/services/user_service.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/services/cart_service.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/services/order_service.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/services/category_service.php");
?>

<?php
$adding_cart_item_error = null;

if (!is_authenticated()) {
  redirect("/commerce/products.php");
}

$user = get_current_signed_in_user();

$get_cart_items_response = get_cart_items($user["id"]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (!is_authenticated()) {
    redirect("/commerce/login.php");
  }

  if (isset($_POST["_action"]) && $_POST["_action"] === "add_to_cart") {

    $cart_id = $user["id"];
    $product_id = $_POST["product_id"];
    $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : 1;

    try {
      $add_cart_item_response = add_cart_item($cart_id, $product_id, $quantity);
    } catch (\Throwable $th) {
      $adding_cart_item_error = "Error adding item to your cart";
    }
  }

  if (isset($_POST["_action"]) && $_POST["_action"] === "delete_cart_item") {

    $cart_item_id = $_POST["cart_item_id"];

    $remove_cart_item_response = remove_cart_item($cart_item_id);
  }

  if (isset($_POST["_action"]) && $_POST["_action"] === "decrease_item_quantity") {

    $cart_item_id = $_POST["cart_item_id"];
    $cart_item_quantity = $_POST["cart_item_quantity"];
    $cart_item_product_id = $_POST["cart_item_product_id"];

    $cart_item_quantity = $cart_item_quantity - 1;

    if ($cart_item_quantity < 1) {
      remove_cart_item($cart_item_id);
      redirect("/commerce/cart.php");
    }

    $update_cart_item_response = update_cart_item($cart_item_id, $cart_item_product_id, $cart_item_quantity);
  }

  if (isset($_POST["_action"]) && $_POST["_action"] === "increase_item_quantity") {

    $cart_item_id = $_POST["cart_item_id"];
    $cart_item_quantity = $_POST["cart_item_quantity"];
    $cart_item_product_id = $_POST["cart_item_product_id"];

    $cart_item_quantity = $cart_item_quantity + 1;
    $update_cart_item_response = update_cart_item($cart_item_id, $cart_item_product_id, $cart_item_quantity);
  }

  if (isset($_POST["_action"]) && $_POST["_action"] === "create_order") {

    $card_holder_name = $_POST["card_holder_name"];
    $card_number = $_POST["card_number"];
    $card_expiration = $_POST["card_expiration"];
    $card_cvv = $_POST["card_cvv"];
    $sub_total_price = $_POST["sub_total_price"];
    $shipping_fee = $_POST["shipping_fee"];
    $total_price = $_POST["total_price"];

    $order_id = create_order($user["id"], $card_holder_name, $card_number, $card_expiration, $card_cvv, $sub_total_price, $shipping_fee, $total_price);

    if ($order_id) {
      remove_all_cart_items($user["id"]);
      redirect("/commerce/products.php");
    } else {
      redirect("/commerce/cart.php");
    }
  }

  $get_cart_items_response = get_cart_items($user["id"]);
}

$cart_items = $get_cart_items_response["data"];

$sub_total = 0;
$shipping_fee = 20;
$total_price = 0;
foreach ($cart_items as $cart_item) {
  $sub_total += $cart_item["product_price"] * $cart_item["cart_item_quantity"];
}
$total_price = $sub_total + $shipping_fee;
?>

<?php include './partials/header.php'; ?>

<body>

  <?php include 'partials/navbar.php'; ?>

  <?php if ($adding_cart_item_error != null) : ?>
    <div class="alert alert-danger" role="alert">
      <?php echo ($adding_cart_item_error) ?>
    </div>
  <?php endif ?>

  <div class="container">
    <h3 class="mb-4">Your Cart items</h3>
  </div>

  <section class="h-100 h-custom" style="background-color: #eee;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col">
          <div class="card">
            <div class="card-body p-4">

              <div class="row">

                <div class="col-lg-7">
                  <h5 class="mb-3"><a href="/commerce/products.php" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Continue shopping</a></h5>
                  <hr>

                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                      <p class="mb-1">Shopping cart</p>
                      <p class="mb-0">You have <?php echo (count($cart_items)) ?> items in your cart</p>
                    </div>
                  </div>

                  <?php foreach ($cart_items as $cart_item) : ?>

                    <div class="card mb-3">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <div class="d-flex flex-row align-items-center">
                            <div>
                              <img src="<?php echo ($cart_item["product_image"]) ?>" class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
                            </div>
                            <div class="ms-3">
                              <h5><?php echo ($cart_item["product_name"]) ?></h5>
                              <p class="small mb-0"><?php echo (get_category_by_id($cart_item["product_category"])["name"]) ?></p>
                            </div>
                          </div>
                          <div class="d-flex flex-row align-items-center">
                            <div style="width: 50px;" class="mx-4">
                              <form action="/commerce/cart.php" method="POST">
                                <input type="hidden" name="cart_item_id" value="<?php echo ($cart_item["cart_item_id"]) ?>">
                                <input type="hidden" name="cart_item_product_id" value="<?php echo ($cart_item["product_id"]) ?>">
                                <input type="hidden" name="cart_item_quantity" value="<?php echo ($cart_item["cart_item_quantity"]) ?>">
                                <button type="submit" name="_action" value="decrease_item_quantity" class="btn btn-warning"><i class="fa-solid fa-minus"></i></button>
                              </form>
                              <h5 class="fw-normal mb-0 text-center"><?php echo ($cart_item["cart_item_quantity"]) ?></h5>
                              <form action="/commerce/cart.php" method="POST">
                                <input type="hidden" name="cart_item_id" value="<?php echo ($cart_item["cart_item_id"]) ?>">
                                <input type="hidden" name="cart_item_product_id" value="<?php echo ($cart_item["product_id"]) ?>">
                                <input type="hidden" name="cart_item_quantity" value="<?php echo ($cart_item["cart_item_quantity"]) ?>">
                                <button type="submit" name="_action" value="increase_item_quantity" class="btn btn-success"><i class="fa-solid fa-plus"></i></button>
                              </form>
                            </div>
                            <div style="width: 80px;">
                              <h5 class="mb-0">$<?php echo ($cart_item["product_price"]) ?></h5>
                            </div>

                            <form action="/commerce/cart.php" method="POST">
                              <input type="hidden" name="cart_item_id" value="<?php echo ($cart_item["cart_item_id"]) ?>">
                              <button name="_action" value="delete_cart_item" type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                  <?php endforeach; ?>

                </div>
                <div class="col-lg-5">

                  <div class="card bg-primary text-white rounded-3">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">Card details</h5>
                      </div>

                      <p class="small mb-2">Card type</p>
                      <a href="#!" type="submit" class="text-white"><i class="fab fa-cc-mastercard fa-2x me-2"></i></a>
                      <a href="#!" type="submit" class="text-white"><i class="fab fa-cc-visa fa-2x me-2"></i></a>
                      <a href="#!" type="submit" class="text-white"><i class="fab fa-cc-amex fa-2x me-2"></i></a>
                      <a href="#!" type="submit" class="text-white"><i class="fab fa-cc-paypal fa-2x"></i></a>

                      <form class="mt-4" action="/commerce/cart.php" method="POST">
                        <div class="form-outline form-white mb-4">
                          <input name="card_holder_name" type="text" id="typeName" class="form-control form-control-lg" siez="17" placeholder="Cardholder's Name" value="<?php echo ($user["first_name"]) ?> <?php echo ($user["last_name"]) ?>" />
                          <label class="form-label" for="typeName">Cardholder's Name</label>
                        </div>

                        <div class="form-outline form-white mb-4">
                          <input name="card_number" type="text" id="typeText" class="form-control form-control-lg" siez="17" placeholder="1234 5678 9012 3457" minlength="19" maxlength="19" />
                          <label class="form-label" for="typeText">Card Number</label>
                        </div>

                        <div class="row mb-4">
                          <div class="col-md-6">
                            <div class="form-outline form-white">
                              <input name="card_expiration" type="text" id="typeExp" class="form-control form-control-lg" placeholder="MM/YYYY" size="7" id="exp" minlength="7" maxlength="7" />
                              <label class="form-label" for="typeExp">Expiration</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-outline form-white">
                              <input name="card_cvv" type="password" id="typeText" class="form-control form-control-lg" placeholder="&#9679;&#9679;&#9679;" size="1" minlength="3" maxlength="3" />
                              <label class="form-label" for="typeText">Cvv</label>
                            </div>
                          </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                          <p class="mb-2">Subtotal</p>
                          <p class="mb-2">$<?php echo ($sub_total) ?></p>
                        </div>

                        <div class="d-flex justify-content-between">
                          <p class="mb-2">Shipping_fee</p>
                          <p class="mb-2">$<?php echo ($shipping_fee) ?></p>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                          <p class="mb-2">Total_price(Incl. taxes)</p>
                          <p class="mb-2">$<?php echo ($total_price) ?></p>
                        </div>

                        <input type="hidden" name="sub_total_price" value="<?php echo ($sub_total) ?>">
                        <input type="hidden" name="shipping_fee" value="<?php echo ($shipping_fee) ?>">
                        <input type="hidden" name="total_price" value="<?php echo ($total_price) ?>">

                        <button type="submit" name="_action" value="create_order" class="btn btn-info btn-block btn-lg">
                          <div class="d-flex justify-content-between">
                            <span>$<?php echo ($total_price) ?></span>
                            <span>Checkout <i class="fas fa-long-arrow-alt-right ms-2"></i></span>
                          </div>
                        </button>
                      </form>

                    </div>
                  </div>

                </div>

              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include("./partials/footer_section.php"); ?>

</body>

<?php include "./partials/footer.php"; ?>