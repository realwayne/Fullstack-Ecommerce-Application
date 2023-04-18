<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/start_session.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/functions.php");
$pdo = require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/database/connection.php");
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
$category_actions_error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($_POST['_action']) && $_POST['_action'] === 'delete_category') {
    $id = $_POST['id'];
    try {
      delete_category($id);
      redirect("/commerce/admins/categories.php");
    } catch (Exception $e) {
      $category_actions_error = "Category could not be deleted.";
    }
  }

  if (isset($_POST['_action']) && $_POST['_action'] === 'create_category') {
    $name = $_POST['name'];
    try {
      create_category($name);
      redirect("/commerce/admins/categories.php");
    } catch (Exception $e) {
      $category_actions_error = "Category could not be created.";
    }
  }

  if (isset($_POST['_action']) && $_POST['_action'] === 'update_category') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    try {
      update_category($id, $name);
      redirect("/commerce/admins/categories.php");
    } catch (Exception $e) {
      $category_actions_error = "Category could not be updated.";
    }
  }
}

?>

<?php
$categories = get_all_categories();
?>

<div>
  <div class="d-flex justify-content-between   mb-2">
    <h2>Categories</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
      Create Category
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Category</h5>
            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">

            <form action="/commerce/admins/categories.php" method="POST">

              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name">
              </div>

              <button type="submit" name="_action" value="create_category" class="btn btn-primary d-inline-block mx-auto">Create</button>
            </form>

          </div>

        </div>
      </div>
    </div>
  </div>
  <?php if ($category_actions_error) : ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $category_actions_error; ?>
    </div>
  <?php endif; ?>
  <div class="table-responsive">
    <!--Table-->
    <table class="table table-striped  ">

      <!--Table head-->
      <thead class="table-primary">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <!--Table head-->

      <!--Table body-->
      <tbody>

        <?php foreach ($categories as $category) : ?>
          <tr>
            <th scope="row"><?php echo ($category["id"]) ?></th>
            <td><?php echo ($category["name"]) ?></td>
            <td>
              <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#edit_modal">
                <i class="fa-solid fa-pen-to-square"></i>
              </button>

              <!-- Modal -->
              <div class="modal fade" id="edit_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
                      <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="/commerce/admins/categories.php" method="POST">

                        <div class="mb-3">
                          <label for="name" class="form-label">Name</label>
                          <input type="text" class="form-control" id="name" name="name" value="<?php echo ($category["name"]) ?>" placeholder="Enter category name">
                        </div>

                        <input type="hidden" name="id" value="<?php echo ($category["id"]) ?>">

                        <button type="submit" name="_action" value="update_category" class="btn btn-primary d-inline-block mx-auto">Update</button>
                      </form>
                    </div>

                  </div>
                </div>
              </div>
              <form class="d-inline" action="/commerce/admins/categories.php" method="POST">
                <input type="hidden" name="id" value="<?php echo ($category["id"]) ?>">
                <button type="submit" name="_action" , value="delete_category" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
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

<?php include("../partials/admins_sidebar_closing.php"); ?>

<?php include("../partials/footer.php"); ?>