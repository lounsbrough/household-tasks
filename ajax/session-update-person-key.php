<?PHP

session_name("household_tasks");
session_start();

$_SESSION["person_key"] = $_GET["person_key"];

?>