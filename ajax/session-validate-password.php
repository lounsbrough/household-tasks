<?PHP

session_name("household_tasks");
session_start();

if ($_GET["password"] != getenv("HTTPS_AUTHENTICATION_SECRET")) {
    throw new Exception('Unable to validate password');
}

$_SESSION["logged_in"] = true;

?>