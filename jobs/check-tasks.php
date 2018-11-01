<?php

require_once dirname(__FILE__).'/../classes/database.php';
$database = new Database();

require_once dirname(__FILE__).'/../classes/pushbullet.php';
$pushbullet = new Pushbullet();

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
		$linkUrl = "https://".getenv('PUBLIC_SERVER_DNS')."/household-tasks/complete-task.php?task_key=".$taskDue["TaskKey"]."&person_key=".$pushbulletDevice["PersonKey"];
		$pushbullet->pushLink($pushbulletDevice["DeviceName"], $taskDue["TaskName"], $linkUrl, 'View Task');
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