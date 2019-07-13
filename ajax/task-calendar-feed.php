<?PHP

header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once dirname(__FILE__).'/../classes/date-functions.php';
$dateFunctions = new DateFunctions();

require_once dirname(__FILE__).'/../classes/database.php';
$database = new Database();

$calendarEvents = array();

$query = "
SELECT 
    *
FROM
    definedtasks;
";

class EventColors {
    const Upcoming = "#007bff";
    const Missed = "#dc3545";
    const Snoozed = "#ffc107";
    const Completed = "#28a745";
}

$results = $database->getResultSet($query);

foreach ($results as $result)
{
    $taskKey = $result["TaskKey"];

    $followingOccurrence = $dateFunctions->calculateNextOccurrenceTMS($result, strtotime($result["NextOccurrenceTMS"]));

    $backgroundColor = EventColors::Upcoming;
    if (strtotime(date("Y-m-d", strtotime($result["NextOccurrenceTMS"]))) < strtotime(date("Y-m-d"))) {
        $backgroundColor = EventColors::Missed;
    }
    else if ($result["Snoozed"])
    {
        $backgroundColor = EventColors::Snoozed;
    }

    $calendarEvents[] = array(
        "id" => $taskKey,
        "title" => $result["TaskName"],
        "url" => "complete-task.php?task_key=$taskKey",
        "backgroundColor" => $backgroundColor,
        "start" => strtotime($result["NextOccurrenceTMS"]) * 1000,
        "end" => strtotime($result["NextOccurrenceTMS"]) * 1000 + $result["DurationMinutes"] * 60 * 1000
    );

    $futureOccurrence = $followingOccurrence;
    while ($futureOccurrence < strtotime(date("Y-m-d")) + 90 * 24 * 3600) {
        $calendarEvents[] = array(
            "id" => $taskKey,
            "title" => $result["TaskName"],
            "url" => "complete-task.php?task_key=$taskKey",
            "backgroundColor" => EventColors::Upcoming,
            "start" => $futureOccurrence * 1000,
            "end" => $futureOccurrence * 1000 + $result["DurationMinutes"] * 60 * 1000
        );

        $futureOccurrence = $dateFunctions->calculateNextOccurrenceTMS($result, $futureOccurrence);
    }
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
    $calendarEvents[] = array(
        "id" => $result["TaskKey"],
        "title" => $result["TaskName"]." (".trim($result["FirstName"]).")",
        "url" => "complete-task.php?task_key=".$result["TaskKey"],
        "backgroundColor" => EventColors::Completed,
        "start" => strtotime($result["CompletedTMS"]) * 1000,
        "end" => strtotime($result["CompletedTMS"]) * 1000 + $result["DurationMinutes"] * 60 * 1000
    );
}

usort($calendarEvents, function ($a, $b) {
    return strcmp(strtolower($a["title"]), strtolower($b["title"]));
});

echo json_encode($calendarEvents);

?>