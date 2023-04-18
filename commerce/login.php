<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/start_session.php");
?>
<?php
$pdo = require("{$_SERVER['DOCUMENT_ROOT']}/commerce/database/connection.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/services/auth_service.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/functions.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/auth_utilities.php");

$login_error = null;


if ($_SERVER['REQUEST_METHOD'] === 'GET' && is_authenticated()) {
  redirect("/commerce/index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST["email"];
  $password = $_POST["password"];

  $loginUserResponse = loginUser($email, $password);
  if ($loginUserResponse["status"]) {
    redirect("/commerce/index.php");
  } else {
    $login_error = $loginUserResponse["message"];
  }
}

?>

<?php include './partials/header.php'; ?>

<body>
  <?php include 'partials/navbar.php'; ?>

  <div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100%;">
      <div class="col-6 ">
        <h1 class="mb-2">Login</h1>
        <form method="POST" action="/commerce/login.php">
          <!-- Email input -->
          <div class="form-outline mb-4">
            <input name="email" type="email" id="form2Example1" class="form-control" />
            <label class="form-label" for="form2Example1">Email address</label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-4">
            <input name="password" type="password" id="form2Example2" class="form-control" />
            <label class="form-label" for="form2Example2">Password</label>
          </div>

          <!-- Login Errors -->
          <?php if ($login_error) : ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $login_error; ?>
            </div>
          <?php endif; ?>

          <!-- Link to Register Page -->
          <p><a class="d-block text-end" href="register.php">Register instead.</a></p>

          <!-- Submit button -->
          <button type="submit" class="btn btn-primary btn-block mb-4">Login</button>

        </form>
      </div>
    </div>
  </div>
  <!-- MDB -->
</body>

<?php include './partials/footer.php'; ?>