<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/start_session.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/commerce/utilities/functions.php");
// This is a logout page. It destroys the session and redirects to the login page.
// session_start();

unset($_SESSION["USER"]);
redirect("/commerce/index.php");
