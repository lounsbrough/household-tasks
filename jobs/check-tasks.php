<?php

define("DIR_PATH","../");

require_once DIR_PATH.'classes/database.php';
$database = new Database();

$query = "
SELECT 
    *
FROM
    definedtasks
WHERE
    NOW() >= NextOccurrenceTMS
        AND LastNotificationTMS <= DATE_ADD(NOW(),
        INTERVAL - 1 DAY);
";

$tasksDue = $database->getResultSet($query);

foreach ($tasksDue as $taskDue)
{
	$query = "
	SELECT 
		*
	FROM
		householdtasks.assignedtasks
			JOIN
		pushbulletdevices ON pushbulletdevices.PersonKey = assignedtasks.PersonKey
	WHERE
		assignedtasks.TaskKey = :taskkey
	";

	$parameters = array(
		array('name' => ':taskkey', 'value' => $resultTasks["TaskKey"])
	);

	$pushbulletDevices = $database->getResultSet($query, $parameters);

	if (empty($pushbulletDevices))
	{
		$query = "
		SELECT 
			*
		FROM
			pushbulletdevices
		WHERE
			ReceiveDefaultNotifications = TRUE
		";

		$pushbulletDevices = $database->getResultSet($query);
	}

	foreach ($pushbulletDevices as $pushbulletDevice)
	{
		try {
			$pushbullet->device($pushbulletDevice["DeviceName"])->pushLink($taskDue["TaskName"],"https://".getenv('PUBLIC_SERVER_DNS')."/household-tasks/complete-task.php?task_key=".$taskDue["TaskKey"]."&person_key=".$pushbulletDevice["PersonKey"],"View Task");
		} catch (Exception $e) {
			error_log("Error sending pushbullet to device: ".$pushbulletDevice["DeviceName"].". ".$e->getMessage());
		}
	}
	
	$query = "
	UPDATE definedtasks 
	SET 
		LastNotificationTMS = NOW()
	WHERE
		TaskKey = :taskkey
	";

	$parameters = array(
		array('name' => ':taskkey', 'value' => $taskDue["TaskKey"])
	);

	$database->executeStatement($query, $parameters);
}
?>