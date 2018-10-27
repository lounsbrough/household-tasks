<?php

define("DIR_PATH","../");

echo "hey!";
die;

include DIR_PATH."includes/Pushbullet/pushbullet.php";

$householdConnection = new PDO("mysql:host=localhost;port=3306;dbname=householdtasks", getenv('MYSQL_DB_USERNAME'), getenv('MYSQL_DB_PASSWORD'));

$query = "Select *
          From   definedtasks
          Where  Current_Timestamp >= NextOccurrenceTMS
          And    LastNotificationTMS <= Date_Add(Current_Timestamp,INTERVAL -1 DAY)";

if ($sqlTasks = $householdConnection->query($query)) {
    while ($resultTasks = $sqlTasks->fetch()) {

    	$query = "Select *
    			  From   PushbulletDevices";
    	if (trim($resultTasks["PersonList"]) != "") {
    		$query .= " Where PersonKey In (".trim($resultTasks["PersonList"]).")";
    	}

    	if ($sqlDevices = $householdConnection->query($query)) {
    		while ($resultDevices = $sqlDevices->fetch()) {
    			try {
					$pushbullet->device($resultDevices["DeviceName"])->pushLink($resultTasks["TaskName"],"https://".getenv('PUBLIC_SERVER_DNS')."/household-tasks/complete-task.php?task_key=".$resultTasks["TaskKey"]."&person_key=".$resultDevices["PersonKey"],"View Task");
				} catch (Exception $e) {
					error_log("Error sending pushbullet to device: ".$resultDevices["DeviceName"].". ".$e->getMessage());
				}
    		}
    	}
    	
		$query = "Update definedtasks
		          Set    LastNotificationTMS = Current_Timestamp
		          Where  TaskKey = ".$resultTasks["TaskKey"];
		$householdConnection->query($query);

    }
}

?>