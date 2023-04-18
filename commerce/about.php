<?php
$pdo = require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/database/connection.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/start_session.php");
?>
<?php include("./partials/header.php"); ?>

<body>
  <?php include("./partials/navbar.php"); ?>

  <div class="px-4 py-5 my-5 text-center" style="background-image: url('/commerce/assets/images/about-us.jpg'); background-position: center center; background-size: cover; margin: 0 !important; padding: 6rem 1rem !important;">
    <h1 class="display-5 fw-bold">About Us</h1>
    <div class="col-lg-6 mx-auto">
      <p>Wayne Shope</p>
    </div>
  </div>
  <div class="container">
    <div class="row justify-content-center">
      <div class=" col-6 px-4 py-5 my-5 text-center">
        <p>
          We believe that travel is for everyone. It helps us learn about ourselves and the world around us.</p>
        <p>
          Our goal is to help more people from more backgrounds experience the joy of exploration. Because we believe this builds a kinder, more inclusive, more open-minded world.</p>
        <p>
          Like you, travel is in our DNA. At Lonely Planet, we believe travel opens the door to the greatest, most unforgettable experiences life can offer. And we have learned that the best travel is about putting yourself out there, about leaving behind the everyday, about immersing yourself, rather than just seeing the sights.</p>
        <p>
          As travelers, you're on a journey, and at Lonely Planet, we're on one, too. Over the last two years, travel has transformed. We're thinking deeply not just about how we travel but why we travel and how to best serve travelers on their journey – and we approach our 50th year with a passion and commitment to helping others do it, too.

        </p>
      </div>
    </div>
  </div>

  <?php include("./partials/footer_section.php"); ?>

</body>

<?php include("./partials/footer.php"); ?>