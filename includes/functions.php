<?php

$taskDefinition = array();

function calculateNextOccurrenceTMS($taskKey, $completedTMS) {

    global $taskDefinition;

    require_once DIR_PATH.'classes/database.php';
    $database = new Database();

    $query = "
    SELECT 
        *
    FROM
        definedtasks
    WHERE
        TaskKey = :taskkey
    ";

    $parameters = array(
        array('name' => ':taskkey', 'value' => $taskKey)
    );
    
    $results = $database->getResultSet($query, $parameters);

    if (!empty($results) )
    {
        $taskDefinition = $results[0];
    }

    if (!isset($taskDefinition)) {
        return false;
    }

    $nextOccurrenceTMS = date("Y-m-d H:i:s",strtotime(date("Y-m-d",$completedTMS)." + ".$taskDefinition["RecurrenceAmount"]." ".$taskDefinition["RecurrenceType"]));

    if (!empty($taskDefinition["WeekDay"]))
    {
        $nextOccurrenceTMS = date("Y-m-d H:i:s",strtotime($nextOccurrenceTMS." - 3 day"));

        $nextOccurrenceTMS = findNextWeekDate($nextOccurrenceTMS);

    }
    else if (!empty($taskDefinition["MonthDay"]))
    {

        $nextOccurrenceTMS = date("Y-m-d H:i:s",strtotime($nextOccurrenceTMS." - 10 day"));

        $nextOccurrenceTMS = findNextMonthDate($nextOccurrenceTMS);

    }
    
    if ($taskDefinition["SpecificTime"]) 
    {
        $nextOccurrenceTMS = date("Y-m-d H:i:s",strtotime(date("Y-m-d",strtotime($nextOccurrenceTMS))." ".$taskDefinition["TimeOfDay"]));
    }

    return strtotime($nextOccurrenceTMS);

}

function findNextWeekDate($startTMS) {

    global $taskDefinition;

    $dateFound = false;
    $nextDate = date("Y-m-d H:i:s",strtotime($startTMS));
    while (!$dateFound) {
        if (date("l",strtotime($nextDate)) == $taskDefinition["WeekDay"]) {
            $nextMatchingDate = date("Y-m-d H:i:s",strtotime($nextDate));
            $dateFound = true;
            break;
        }
        $nextDate = date("Y-m-d H:i:s",strtotime($nextDate." + 1 day"));
    }

    return $nextMatchingDate;

}

function findNextMonthDate($startTMS) {

    global $taskDefinition;

    $dateFound = false;
    $nextDate = date("Y-m-d H:i:s",strtotime($startTMS));
    while (!$dateFound) {
        if (date("j",strtotime($nextDate)) == $taskDefinition["MonthDay"] ||
            ($taskDefinition["MonthDay"] > date("t",strtotime($nextDate)) && date("j",strtotime($nextDate)) == date("t",strtotime($nextDate)))) {
            $nextMatchingDate = date("Y-m-d H:i:s",strtotime($nextDate));
            $dateFound = true;
            break;
        }
        $nextDate = date("Y-m-d H:i:s",strtotime($nextDate." + 1 day"));
    }

    return $nextMatchingDate;

}

?>