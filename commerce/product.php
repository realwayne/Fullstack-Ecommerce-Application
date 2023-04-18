<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/start_session.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/services/product_service.php");
$pdo = require("{$_SERVER['DOCUMENT_ROOT']}/commerce/database/connection.php");
?>

<?php
if (isset($_GET['product_id'])) {
  $product_id = (int) $_GET['product_id'];
  $product = get_product_by_id($product_id);
  // print_r($product);
}
?>

<?php include("./partials/header.php"); ?>

<body>
  <?php include("./partials/navbar.php"); ?>

  <div class="container">

    <a href="/commerce/products.php?category_id=<?php echo ($product["category_id"]) ?>" class="btn btn-primary" tabindex="-1" role="button" aria-disabled="true">Go Back</a>

    <div class="w-75 m-auto">

      <!-- IMAGE -->
      <div class="image">
        <img class="img-fluid d-block w-100" src="<?php echo ($product["image"]) ?>" alt="<?php echo ($product["name"]) ?>">
      </div>

      <!-- BODY -->
      <div class="body ">

        <div class="name ">
          <h1 class="mt-2"><?php echo ($product["name"]) ?></h1>
          <span class="badge text-bg-primary"><?php echo ($product["category_name"]) ?></span>
        </div>

        <div class="price d-flex align-items-center justify-content-between">

          <h2 class="mt-2">$<?php echo ($product["price"]) ?></h2>

          <form method="POST" action="/commerce/cart.php">
            <input type="hidden" name="product_id" value="<?php echo ($product["id"]) ?>" />
            <button type="submit" name="_action" value="add_to_cart" value="<?php echo ($product["id"]) ?>" class="btn btn-success">Add to Cart</button>
          </form>

        </div>

      </div>

      <!-- DIVIDER -->
      <hr class="mt-2">

      <div class="description mt-2">
        <h4>Description</h4>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae reprehenderit earum consequatur eos accusamus quod ipsam corporis quam. Repellendus alias delectus quasi voluptatem incidunt nostrum! Debitis obcaecati officia laborum distinctio quaerat odio, porro autem, soluta enim eum aut ullam iure voluptas nihil at inventore, voluptate pariatur recusandae laudantium temporibus? Accusantium?
        </p>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Doloremque non maxime, earum nihil dolorum ab velit fugiat. Nostrum reprehenderit quis, nam numquam rem quam accusamus quisquam praesentium corrupti omnis dolor suscipit, error dolore deserunt perspiciatis ex eos rerum mollitia? Nihil aperiam cumque atque molestias sed itaque eum, fuga quos non, culpa accusamus! Repudiandae unde voluptate optio debitis quas reiciendis porro omnis, aliquam sequi vel sint qui perferendis possimus alias ipsa voluptates nulla ut cum odio eaque nihil? Harum possimus adipisci consectetur magni assumenda, labore, id commodi dolorum ratione laboriosam, error doloremque animi illo quidem tempora vitae? Maxime, molestiae. Voluptatum, dicta.</p>
      </div>

      <!-- GENERATE RATINGS -->
      <div class="description mt-2">
        <h4>Feeback</h4>
      </div>


    </div>

  </div>

  <?php include("./partials/footer_section.php"); ?>

</body>

<?php include("./partials/footer.php"); ?>