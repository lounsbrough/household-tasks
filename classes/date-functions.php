<?php
Class DateFunctions
{
    public function calculateNextOccurrenceTMS($taskKey, $completedTMS) 
    {
        require_once dirname(__FILE__).'/database.php';
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

        if (!empty($results))
        {
            $taskDefinition = $results[0];
        }

        if (empty($taskDefinition)) {
            return false;
        }

        $nextOccurrenceTMS = date("Y-m-d H:i:s", strtotime(date("Y-m-d",$completedTMS)." + ".$taskDefinition["RecurrenceAmount"]." ".$taskDefinition["RecurrenceType"]));

        if (!empty($taskDefinition["WeekDay"]))
        {
            $nextOccurrenceTMS = $this->findNextWeekDate(new DateTime($nextOccurrenceTMS." - 10 day"), $taskDefinition["WeekDay"]);
        }
        else if (!empty($taskDefinition["MonthDay"]))
        {
            $nextOccurrenceTMS = $this->findNextMonthDate(new DateTime($nextOccurrenceTMS." - 10 day"), $taskDefinition["MonthDay"]);
        }
        
        if ($taskDefinition["SpecificTime"]) 
        {
            $nextOccurrenceTMS = date("Y-m-d H:i:s", strtotime(date("Y-m-d",strtotime($nextOccurrenceTMS))." ".$taskDefinition["TimeOfDay"]));
        }

        return strtotime($nextOccurrenceTMS);
    }

    private function findNextWeekDate($startTMS, $weekDay) 
    {
        $nextDate = $startTMS;
        $nextDate->modify("next $weekDay");
        return $nextDate->format("Y-m-d H:i:s");
    }

    private function findNextMonthDate($startTMS, $monthDay) 
    {
        $nextDate = $startTMS;
        while (!($nextDate->format("j") == $monthDay || 
                ($nextDate->getTimestamp() > $startTMS->getTimestamp() && $monthDay > $nextDate->format("t") && $nextDate->format("j") == $nextDate->format("t")))) {
            $nextDate->modify(" + 1 day");
        }

        return $nextDate->format("Y-m-d H:i:s");
    }
}
?>