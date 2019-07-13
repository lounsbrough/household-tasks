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

<div class="row" style="display: none">
    <div class="col-sm-12">
        <h3></h3>
        <div class="date-header-btn pull-left form-inline">
            <div class="btn-group">
                <button class="btn active" data-calendar-view="month">List View</button>
            </div>
        </div>
    </div>
</div>

<div id="task-calendar-div" class="cal-context"></div>

<?php

$footerContent = '
    <script>
        var calendarView = "'.($_SESSION["calendar_view"] ?? 'listWeek').'"
    </script>

    <script src="'.DIR_PATH.'js/task-calendar.js"></script>
';

require dirname(__FILE__)."/includes/footer.php";

?>