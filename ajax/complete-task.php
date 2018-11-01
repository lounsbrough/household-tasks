<?PHP

define('DIR_PATH', '');

header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_GET["task_key"]) || !isset($_GET["person_key"]) || !isset($_GET["completed_tms"]))
{
    die;
}

$taskKey = $_GET["task_key"];
$personKey = $_GET["person_key"];
$completedTMS = date("Y-m-d H:i:s",strtotime($_GET["completed_tms"]));

require_once dirname(__FILE__).'/../classes/date-functions.php';
$dateFunctions = new DateFunctions();

require_once dirname(__FILE__).'/../classes/database.php';
$database = new Database();

$query = "
SELECT 
    *
FROM
    completedtasks
WHERE
    TaskKey = :taskkey
		AND CAST(CompletedTMS AS DATE) = CAST(:completedtms AS DATE)
";

$parameters = array(
	array('name' => ':taskkey', 'value' => $taskKey),
	array('name' => ':completedtms', 'value' => $completedTMS)
);

$results = $database->getResultSet($query, $parameters);

if (empty($results)) 
{
	$query = "
	INSERT INTO completedtasks (
		TaskKey, 
		CompletedTMS, 
		PersonKey
	) VALUES (
		:taskkey, 
		:completedtms, 
		:personkey
	)
	";

	$parameters = array(
		array('name' => ':taskkey', 'value' => $taskKey),
		array('name' => ':completedtms', 'value' => $completedTMS),
		array('name' => ':personkey', 'value' => $personKey)
	);

	$database->executeStatement($query, $parameters);
} 
else 
{
	$query = "
	UPDATE completedtasks 
	SET 
		CompletedTMS = :completedtms,
		PersonKey = :personkey
	WHERE
		TaskKey = :taskkey
			AND CAST(CompletedTMS AS DATE) = CAST(:completedtms AS DATE)
	";

	$parameters = array(
		array('name' => ':taskkey', 'value' => $taskKey),
		array('name' => ':completedtms', 'value' => $completedTMS),
		array('name' => ':personkey', 'value' => $personKey)
	);

	$database->executeStatement($query, $parameters);
}

if ($nextOccurrenceTMS = $dateFunctions->calculateNextOccurrenceTMS($taskKey, strtotime($completedTMS))) {

	$query = "
	UPDATE definedtasks 
	SET 
		NextOccurrenceTMS = :nextoccurrencetms,
		Snoozed = FALSE
	WHERE
		TaskKey = :taskkey
	";
			  
	$parameters = array(
		array('name' => ':taskkey', 'value' => $taskKey),
		array('name' => ':nextoccurrencetms', 'value' => date("Y-m-d H:i:s",$nextOccurrenceTMS))
	);

	$database->executeStatement($query, $parameters);
}

?>