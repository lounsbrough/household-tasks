<?php

require_once dirname(__FILE__).'/../classes/database.php';
$database = new Database();

require_once dirname(__FILE__).'/../classes/pushbullet.php';
$pushbullet = new Pushbullet();

function sendPushbulletNotifications($database, $pushbullet, $tasksDue) {
	$query = "
	SELECT 
		*
	FROM
		pushbulletdevices
	WHERE
		ReceiveDefaultNotifications = TRUE
	";

	$activePushbulletDevices = $database->getResultSet($query);
	$notifications = [];
	foreach ($activePushbulletDevices as $pushbulletDevice) {
		$notifications[$pushbulletDevice["DeviceName"]] = [];
	}

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
			array('name' => ':taskkey', 'value' => $taskDue["TaskKey"])
		);

		$taskPushbulletDevices = $database->getResultSet($query, $parameters);

		if (empty($taskPushbulletDevices)) {
			$taskPushbulletDevices = $activePushbulletDevices;
		}

		foreach ($taskPushbulletDevices as $pushbulletDevice)
		{
			array_push($notifications[$pushbulletDevice], $taskDue);
		}
	}

	foreach ($notifications as $pushbulletDevice => $notification) {
		if (count($notification) == 1) {
			$linkUrl = "https://".getenv('PUBLIC_SERVER_DNS')."/household-tasks/complete-task.php?task_key=".$notification[0]["TaskKey"]."&person_key=".$pushbulletDevice["PersonKey"];
			$pushbullet->pushLink($pushbulletDevice["DeviceName"], $notification[0]["TaskName"], $linkUrl, 'View Task');
		} else {
			$linkUrl = "https://".getenv('PUBLIC_SERVER_DNS')."/household-tasks";
			$pushbullet->pushLink($pushbulletDevice["DeviceName"], $notification[0]["TaskName"], $linkUrl, 'View All Tasks');
		}
	}
}

function markTaskNotificationsSent($database, $tasksDue) {
	foreach ($tasksDue as $taskDue)
	{	
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
}

$query = "
SELECT 
    *
FROM
    definedtasks
WHERE
    NOW() >= NextOccurrenceTMS
        AND (LastNotificationTMS IS NULL
        OR LastNotificationTMS <= DATE_ADD(NOW(), INTERVAL - 1 DAY));
";

$tasksDue = $database->getResultSet($query);

sendPushbulletNotifications($database, $pushbullet, $tasksDue);
markTaskNotificationsSent($database, $tasksDue);
?>