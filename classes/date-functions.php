<?php
Class DateFunctions
{
    public function calculateNextOccurrenceTMS($taskDefinition, $startTMS) 
    {
        $nextTMS = date("Y-m-d H:i:s", strtotime(date("Y-m-d", $startTMS)." + ".$taskDefinition["RecurrenceAmount"]." ".$taskDefinition["RecurrenceType"]));

        if (!empty($taskDefinition["WeekDay"]))
        {
            $nextTMS = $this->findNextWeekDate(new DateTime($nextTMS." - 3 day"), $taskDefinition["WeekDay"]);
        }
        else if (!empty($taskDefinition["MonthDay"]))
        {
            $nextTMS = $this->findNextMonthDate(new DateTime($nextTMS." - 10 day"), $taskDefinition["MonthDay"]);
        }
        
        if ($taskDefinition["SpecificTime"]) 
        {
            $nextTMS = date("Y-m-d H:i:s", strtotime(date("Y-m-d",strtotime($nextTMS))." ".$taskDefinition["TimeOfDay"]));
        }

        return strtotime($nextTMS);
    }

    private function findNextWeekDate($startTMS, $weekDay) 
    {
        $nextDate = $startTMS;
        $nextDate->modify($weekDay);
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