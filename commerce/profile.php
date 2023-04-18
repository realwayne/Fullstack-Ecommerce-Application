<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/start_session.php");
$pdo = require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/database/connection.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/services/user_service.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/functions.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/user_utilities.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/services/auth_service.php");
?>

<?php
$signed_in_user = get_current_signed_in_user();
$user = get_user_by_id($signed_in_user["id"]);
if (!$user) {
  redirect("/commerce/logout.php");
  exit();
}
?>


<?php
$password_change_status = false;;
$password_change = ["status" => false, "message" => ""];
$profile_update_status = false;
$profile_update = ["status" => false, "message" => ""];
$update_profile_error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST["_action"];

  if ($action === "change_password") {

    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];

    $changePasswordResponse = changePassword($user["id"], $old_password, $new_password);

    if ($changePasswordResponse["status"]) {
      $user = get_current_signed_in_user();
      $_SESSION["USER"] = $user;
      $password_change["status"] = $changePasswordResponse["status"];
      $password_change["message"] = $changePasswordResponse["message"];
    } else {
      $password_change["status"] = $changePasswordResponse["status"];
      $password_change["message"] = $changePasswordResponse["message"];
    }
    $password_change_status = true;
  }

  if ($action === "update_profile") {

    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["new_email"];
    $profile_picture = $_FILES["new_profile_picture"];


    $profile_image_name = $profile_picture['name'];
    $profile_image_tmp_name = $profile_picture['tmp_name'];
    $profile_image_size = $profile_picture['size'];
    $profile_image_error = $profile_picture['error'];
    $profile_image_type = $profile_picture['type'];

    $profile_image_ext = explode('.', $profile_image_name);
    $profile_image_actual_ext = strtolower(end($profile_image_ext));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($profile_image_actual_ext, $allowed)) {
      if ($profile_image_error === 0) {
        if ($profile_image_size < 1000000) {
          $profile_image_newname = uniqid('', true) . "." . $profile_image_actual_ext;
          $profile_image_destination = "{$_SERVER['DOCUMENT_ROOT']}/commerce/assets/images/profiles/" . $profile_image_newname;
          move_uploaded_file($profile_image_tmp_name, $profile_image_destination);
          $profile_image_path = "/commerce/assets/images/profiles/" . $profile_image_newname;
          update_profile($user["id"], $first_name, $last_name, $email, $profile_image_path);
          redirect("/commerce/profile.php");
        } else {
          $update_profile_error = "Your file is too big!";
        }
      } else {
        $update_profile_error = "There was an error uploading your file!";
      }
    } else {
      $update_profile_error = "You cannot upload files of this type!";
    }
  }

  $user = get_user_by_id($user["id"]);
}
?>

<?php include("./partials/header.php"); ?>

<body>
  <?php include("./partials/navbar.php"); ?>

  <div class="container">

    <!-- PROFILE SECTION -->
    <section class="profile w-50 m-auto shadow p-5 mb-5 bg-white rounded">
      <img src="<?php echo ($user["profile_picture"]) ?>" class="rounded mx-auto d-block" style="max-width: 300px; max-height: 400px;" alt="<?php echo ($user["first_name"]) ?>">

      <h1 class="mt-2 text-center"><?php echo ($user["first_name"]) ?> <?php echo ($user["last_name"]) ?></h1>
      <h5 class="text-center"><?php echo ($user["email"]) ?></h5>

    </section>

    <!-- UPDATE PROFILE SECTION -->
    <section class="update-profile shadow p-5 mb-5 bg-white rounded">
      <h3 class="mb-2">Update Profile</h3>
      <div class="row">

        <div class="col-md-4  ">
          <img id="profile_picture_previewer" src="<?php echo ($user["profile_picture"]) ?>" class="rounded mx-auto d-block" style="display: inline-block; width: 100%; height: 100%; object-fit: contain;" alt="<?php echo ($user["first_name"]) ?>">
        </div>

        <div class="col-md-8 ">

          <form method="POST" action="/commerce/profile.php" enctype="multipart/form-data">

            <div class="mb-3">
              <label for="first_name_input" class="form-label">Firstname</label>
              <input name="first_name" type="text" class="form-control" id="first_name_input" value="<?php echo ($user["first_name"]) ?>">
            </div>

            <div class="mb-3">
              <label for="last_name_input" class="form-label">Lastname</label>
              <input name="last_name" type="text" class="form-control" id="last_name_input" value="<?php echo ($user["last_name"]) ?>">
            </div>

            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Email address</label>
              <input name="new_email" type="email" class="form-control" id="exampleInputEmail1" value="<?php echo ($user["email"]) ?>">
            </div>

            <div class="mb-3">
              <label for="file" class="form-label">New Profile Picture</label>
              <input name="new_profile_picture" type="file" accept="image/*" class="form-control" id="file">
            </div>

            <?php if ($profile_update_status) : ?>
              <?php if ($profile_update["status"]) : ?>
                <div class="alert alert-success" role="alert">
                  <?php echo ($profile_update["message"]) ?>
                </div>
              <?php else : ?>
                <div class="alert alert-danger" role="alert">
                  <?php echo ($profile_update["message"]) ?>
                </div>
              <?php endif; ?>
            <?php endif; ?>

            <button type="submit" name="_action" value="update_profile" class="btn btn-primary">Update Profile</button>
          </form>

        </div>

      </div>

    </section>

    <!-- CHANGE PASSWORD SECTION -->
    <section class="update-profile shadow p-5 mb-5 bg-white rounded">
      <h3 class="mb-2">Change Password</h3>
      <div>
        <form method="POST" action="/commerce/profile.php">
          <div class="mb-3">
            <label for="old_password" class="form-label">Old Password</label>
            <input type="text" name="old_password" class="form-control" id="old_password">
          </div>
          <div class="mb-3">
            <label for="new_password" class="form-label">New Password</label>
            <input type="text" name="new_password" class="form-control" id="new_password">
          </div>

          <?php if ($password_change_status) : ?>
            <?php if ($password_change["status"]) : ?>
              <div class="alert alert-success" role="alert">
                <?php echo ($password_change["message"]) ?>
              </div>
            <?php else : ?>
              <div class="alert alert-danger" role="alert">
                <?php echo ($password_change["message"]) ?>
              </div>
            <?php endif; ?>
          <?php endif; ?>

          <button type="submit" name="_action" value="change_password" class="btn btn-primary">Change Password</button>
        </form>
      </div>
    </section>

  </div>

  <?php include("./partials/footer_section.php"); ?>

  <script>
    const fileInput = document.getElementById("file");
    const previewer = document.getElementById("profile_picture_previewer");

    fileInput.addEventListener("change", function(event) {
      const [file] = event.target.files
      if (file) {
        previewer.src = URL.createObjectURL(file)
      }
    });
  </script>

</body>

<?php include("./partials/footer.php"); ?>