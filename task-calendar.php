<?php

$pageTitle = "Task Calendar";

define('DIR_PATH', '');

$headerContent = '
    <link href="'.DIR_PATH.'assets/fullcalendar-4.2.0/packages/core/main.min.css" rel="stylesheet">
    <link href="'.DIR_PATH.'assets/fullcalendar-4.2.0/packages/daygrid/main.min.css" rel="stylesheet">
    <link href="'.DIR_PATH.'assets/fullcalendar-4.2.0/packages/list/main.min.css" rel="stylesheet">
    <script src="'.DIR_PATH.'assets/fullcalendar-4.2.0/packages/core/main.min.js"></script>
    <script src="'.DIR_PATH.'assets/fullcalendar-4.2.0/packages/daygrid/main.min.js"></script>
    <script src="'.DIR_PATH.'assets/fullcalendar-4.2.0/packages/list/main.min.js"></script>
';

require dirname(__FILE__).'/includes/header.php';

?>

<div id="task-calendar-div"></div>

<?php

$footerContent = '
    <script>
        var calendarView = "'.($_SESSION["calendar_view"] ?? 'listWeek').'"
    </script>

    <script src="'.DIR_PATH.'js/task-calendar.js"></script>
';

require dirname(__FILE__)."/includes/footer.php";

?>