<?PHP

session_name("household_tasks");
session_start();

$_SESSION["calendar_view"] = $_GET["calendar_view"];

?>