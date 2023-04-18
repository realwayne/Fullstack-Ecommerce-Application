<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/start_session.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/functions.php");
$pdo = require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/database/connection.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/services/product_service.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/services/category_service.php");

?>

<?php
if (!isAuthenticated() || !isAdmin()) {
  redirect("/commerce/index.php");
}
?>

<?php include("../partials/header.php"); ?>

<?php include("../partials/admins_sidebar.php") ?>

<?php
$delete_product_error = null;
$create_product_error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($_POST['_action']) && $_POST['_action'] === 'delete_product') {
    $id = $_POST['id'];
    try {
      delete_product($id);
      redirect("/commerce/admins/products.php");
    } catch (Exception $e) {
      $delete_product_error = "Product could not be deleted.";
    }
  }

  if (isset($_POST['_action']) && $_POST['_action'] === 'create_product') {

    $product_name = $_POST['product_name'];
    $product_image = $_FILES['product_image'];
    $product_price = $_POST['product_price'];
    $product_category = $_POST['product_category'];

    $product_image_name = $product_image['name'];
    $product_image_tmp_name = $product_image['tmp_name'];
    $product_image_size = $product_image['size'];
    $product_image_error = $product_image['error'];
    $product_image_type = $product_image['type'];

    $product_image_ext = explode('.', $product_image_name);
    $product_image_actual_ext = strtolower(end($product_image_ext));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($product_image_actual_ext, $allowed)) {
      if ($product_image_error === 0) {
        if ($product_image_size < 1000000) {
          $product_image_new_name = uniqid('', true) . "." . $product_image_actual_ext;
          $product_image_destination = "{$_SERVER['DOCUMENT_ROOT']}/commerce/assets/images/products/" . $product_image_new_name;
          move_uploaded_file($product_image_tmp_name, $product_image_destination);
          $product_image_path = "/commerce/assets/images/products/" . $product_image_new_name;
          create_product(["name" => $product_name, "image" => $product_image_path, "price" => $product_price, "category_id" => $product_category]);
          redirect("/commerce/admins/products.php");
        } else {
          $create_product_error = "Your file is too big!";
        }
      } else {
        $create_product_error = "There was an error uploading your file!";
      }
    } else {
      $create_product_error = "You cannot upload files of this type!";
    }
  }

  if (isset($_POST['_action']) && $_POST['_action'] === 'update_product') {
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $product_image = $_FILES['product_image'];
    $product_price = $_POST['product_price'];
    $product_category = $_POST['product_category'];

    $product_image_name = $product_image['name'];
    $product_image_tmp_name = $product_image['tmp_name'];
    $product_image_size = $product_image['size'];
    $product_image_error = $product_image['error'];
    $product_image_type = $product_image['type'];

    $product_image_ext = explode('.', $product_image_name);
    $product_image_actual_ext = strtolower(end($product_image_ext));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($product_image_actual_ext, $allowed)) {
      if ($product_image_error === 0) {
        if ($product_image_size < 1000000) {
          $product_image_new_name = uniqid('', true) . "." . $product_image_actual_ext;
          $product_image_destination = "{$_SERVER['DOCUMENT_ROOT']}/commerce/assets/images/products/" . $product_image_new_name;
          move_uploaded_file($product_image_tmp_name, $product_image_destination);
          $product_image_path = "/commerce/assets/images/products/" . $product_image_new_name;
          update_product(["id" => $id, "name" => $product_name, "image" => $product_image_path, "price" => $product_price, "category_id" => $product_category]);
          redirect("/commerce/admins/products.php");
        } else {
          $create_product_error = "Your file is too big!";
        }
      } else {
        $create_product_error = "There was an error uploading your file!";
      }
    } else {
      $create_product_error = "You cannot upload files of this type!";
    }
  }
}

?>

<?php
$products = get_all_products();
$categories = get_all_categories();
?>

<div>
  <div class="d-flex justify-content-between   mb-2">
    <h2>Products</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
      Create Product
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/commerce/admins/products.php" method="POST" enctype="multipart/form-data">

              <div class="image_previewer mb-2">
                <img id="image_previewer" class="img-thumbnail" src="" alt="">
              </div>

              <div class="form-outline mb-2">
                <label class="form-label" for="product_image_input">Product Image</label>
                <input name="product_image" type="file" id="product_image_input" />
              </div>

              <div class="form-outline mb-2">
                <input name="product_name" type="text" id="product_name" class="form-control" />
                <label class="form-label" for="product_name">Product Name</label>
              </div>

              <div class="form-outline mb-4">
                <label class="form-label d-block" for="form2Example1">Category</label>
                <select name="product_category" class="form-select" aria-label="Default select example">
                  <option selected disabled>Select Category</option>
                  <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon3">Price</span>
                <input name="product_price" type="number" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="0">
              </div>

              <div class="text-center by-2">
                <button class="btn btn-primary btn-lg" type="submit" name="_action" value="create_product">Create Product</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="table-responsive">
    <!--Table-->
    <table class="table table-striped  ">

      <!--Table head-->
      <thead class="table-primary">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Image</th>
          <th>Actions</th>
        </tr>
      </thead>
      <!--Table head-->

      <!--Table body-->
      <tbody>

        <?php foreach ($products as $product) : ?>
          <tr>
            <th scope="row"><?php echo ($product["id"]) ?></th>
            <td><?php echo ($product["name"]) ?></td>
            <td><?php echo ($product["category_name"]) ?> </td>
            <td><?php echo ($product["price"]) ?></td>
            <td><img class="d-block" style="width: 4rem; height: 4rem;" src="<?php echo ($product["image"]) ?>" alt=""></td>
            <td>
              <button type="button" class="btn btn-warning" data-mdb-toggle="modal" data-mdb-target="#edit_product_modal">
                <i class="fa-solid fa-pen-to-square"></i>
              </button>

              <!-- Modal -->
              <div class="modal fade" id="edit_product_modal" tabindex="-1" aria-labelledby="edit_product_modal_label" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="edit_product_modal_label">Update Product</h5>
                      <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="/commerce/admins/products.php" method="POST" enctype="multipart/form-data">

                        <div class="image_previewer mb-2">
                          <img id="update_image_previewer" class="img-thumbnail" src="<?php echo ($product["image"]) ?>" alt="<?php echo ($product["name"]) ?>">
                        </div>

                        <div class="form-outline mb-2">
                          <label class="form-label" for="update_product_image_input">Product Image</label>
                          <input name="product_image" type="file" id="update_product_image_input" />
                        </div>

                        <div class="form-outline mb-2">
                          <input name="product_name" type="text" id="product_name" class="form-control border" value="<?php echo ($product["name"]) ?>" />
                          <label class="form-label" for="product_name">Product Name</label>
                        </div>

                        <div class="form-outline mb-4">
                          <label class="form-label d-block" for="form2Example1">Category</label>
                          <select name="product_category" class="form-select" aria-label="Default select example">
                            <option disabled>Select Category</option>
                            <?php foreach ($categories as $category) : ?>
                              <option <?php echo ($category["id"] === $product["category_id"] ? "selected" : "") ?> value="<?php echo $category['id'] ?>"><?php echo $category['name']  ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>

                        <div class="input-group mb-3">
                          <span class="input-group-text" id="basic-addon3">Price</span>
                          <input name="product_price" type="number" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="0" value="<?php echo ($product["price"]) ?>">
                        </div>

                        <input type="hidden" name="id" value="<?php echo ($product["id"]) ?>">

                        <div class="text-center by-2">
                          <button class="btn btn-primary btn-lg" type="submit" name="_action" value="update_product">Update Product</button>
                        </div>

                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <form class="d-inline" action="/commerce/admins/products.php" method="POST">
                <input type="hidden" name="id" value="<?php echo ($product["id"]) ?>">
                <button type="submit" class="btn btn-danger" name="_action" value="delete_product"><i class="fa-solid fa-trash"></i></button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>

      </tbody>
      <!--Table body-->
    </table>
    <!--Table-->
  </div>

</div>

<script>
  const image_previewer = document.querySelector("#image_previewer");
  const product_image_input = document.querySelector("#product_image_input");
  product_image_input.addEventListener("change", (e) => {
    const [file] = e.target.files
    if (file) {
      image_previewer.src = URL.createObjectURL(file)
    }
  });

  const update_image_previewer = document.querySelector("#update_image_previewer");
  const update_product_image_input = document.querySelector("#update_product_image_input");
  update_product_image_input.addEventListener("change", (e) => {
    const [file] = e.target.files
    console.log(file)
    if (file) {
      update_image_previewer.src = URL.createObjectURL(file)
    }
  });
</script>

<?php include("../partials/admins_sidebar_closing.php"); ?>

<?php include("../partials/footer.php"); ?>