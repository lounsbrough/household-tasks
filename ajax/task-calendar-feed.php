<?PHP

header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once dirname(__FILE__).'/../classes/database.php';
$database = new Database();

$calendarEvents = array(
    "success" => "1",
    "result" => array()
);

$query = "
SELECT 
    *
FROM
    definedtasks;
";

$results = $database->getResultSet($query);

foreach ($results as $result)
{
    $event_class = "event-info";
    if (strtotime(date("Y-m-d", strtotime($result["NextOccurrenceTMS"]))) < strtotime(date("Y-m-d"))) {
        $event_class = "event-important";
    }
    else if ($result["Snoozed"])
    {
        $event_class = "event-warning";
    }

    $calendarEvents["result"][] = array(
        "id" => $result["TaskKey"],
        "title" => $result["TaskName"],
        "url" => "complete-task.php?task_key=".$result["TaskKey"],
        "class" => $event_class,
        "start" => strtotime($result["NextOccurrenceTMS"]) * 1000,
        "end" => strtotime($result["NextOccurrenceTMS"]) * 1000 + $result["DurationMinutes"] * 60 * 1000
    );
}

$query = "
SELECT 
    *
FROM
    completedtasks
        JOIN
    definedtasks ON definedtasks.TaskKey = completedtasks.TaskKey
        JOIN
    persons ON persons.PersonKey = completedtasks.PersonKey
";

$results = $database->getResultSet($query);

foreach ($results as $result)
{
    $event_class = "event-success";
    
    $calendarEvents["result"][] = array(
        "id" => $result["TaskKey"],
        "title" => $result["TaskName"]." (".trim($result["FirstName"]).")",
        "url" => "complete-task.php?task_key=".$result["TaskKey"],
        "class" => $event_class,
        "start" => strtotime($result["CompletedTMS"]) * 1000,
        "end" => strtotime($result["CompletedTMS"]) * 1000 + $result["DurationMinutes"] * 60 * 1000
    );
}

echo json_encode($calendarEvents);

?>