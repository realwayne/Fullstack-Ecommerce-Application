<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/start_session.php");
?>
<?php
$pdo = require("{$_SERVER['DOCUMENT_ROOT']}/commerce/database/connection.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/services/auth_service.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/functions.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/auth_utilities.php");

$registration_error = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && is_authenticated()) {
  redirect("/commerce/index.php");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $firstname = $_POST["firstname"];
  $lastname = $_POST["lastname"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  $register_user_response = registerUser($firstname, $lastname, $email, $password);

  if ($register_user_response["status"]) {
    $login_user_response = loginUser($email, $password);

    if ($login_user_response["status"]) {
      redirect("/commerce/index.php");
    } else {
      $registration_error = $login_user_response["message"];
    }
  } else {
    $registration_error = $register_user_response["message"];
  }
}


?>

<?php include './partials/header.php'; ?>

<?php include 'partials/navbar.php'; ?>

<body>

  <div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100%;">
      <div class="col-6 ">
        <h1 class="mb-2">Register</h1>
        <form method="POST" action="/commerce/register.php">

          <div class="row">
            <div class="col col-md-6 col-sm-12">
              <!-- Firstname -->
              <div class="form-outline mb-4">
                <input type="text" name="firstname" id="firstname" class="form-control" />
                <label class="form-label" for="firstname">Firstname</label>
              </div>
            </div>
            <div class="col col-md-6  col-sm-12">
              <!-- Lastname -->
              <div class="form-outline mb-4">
                <input type="text" name="lastname" id="lastname" class="form-control" />
                <label class="form-label" for="lastname">Lastname</label>
              </div>
            </div>
          </div>

          <!-- Email input -->
          <div class="form-outline mb-4">
            <input type="email" name="email" id="form2Example1" class="form-control" />
            <label class="form-label" for="form2Example1">Email address</label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-4">
            <input name="password" type="password" id="form2Example2" class="form-control" />
            <label class="form-label" for="form2Example2">Password</label>
          </div>

          <!-- Registration Errors -->
          <?php if ($registration_error) : ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $registration_error; ?>
            </div>
          <?php endif; ?>

          <p><a class="d-block text-end" href="login.php">Login instead.</a></p>

          <!-- Submit button -->
          <button type="submit" class="btn btn-primary btn-block mb-4">Register</button>

        </form>
      </div>
    </div>
  </div>

</body>

<?php include './partials/footer.php'; ?>