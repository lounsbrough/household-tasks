<?PHP

define("DIR_PATH","../");

header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_GET["task_key"]))
{
	die;
}

if (isset($_GET["snooze_amount"]) && isset($_GET["snooze_type"])) 
{
	$nextOccurrenceTMS = date("Y-m-d H:i:s", strtotime("+ ".$_GET["snooze_amount"]." ".$_GET["snooze_type"]));
}
else if (isset($_GET["snooze_until"]))
{
	$nextOccurrenceTMS = date("Y-m-d H:i:s", strtotime($_GET["snooze_until"]));
}
else
{
	die;
}

require_once DIR_PATH.'classes/database.php';
$database = new Database();

$query = "
UPDATE definedtasks 
SET 
	NextOccurrenceTMS = :nextoccurrencetms,
	LastNotificationTMS = '2000-01-01 00:00:00',
	Snoozed = TRUE
WHERE
	TaskKey = :taskkey
";
		  
$parameters = array(
	array('name' => ':nextoccurrencetms', 'value' => $nextOccurrenceTMS),
	array('name' => ':taskkey', 'value' => $_GET["task_key"])
);

$database->getResultSet($query, $parameters);

?>