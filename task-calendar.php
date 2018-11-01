<?php

$pageTitle = "Task Calendar";

define('DIR_PATH', '');

$headerContent = '<link href="'.DIR_PATH.'assets/bootstrap-calendar-master/css/calendar.min.css" rel="stylesheet">';
require dirname(__FILE__).'/includes/header.php';

?>

            <div class="page-header" style="border:none">

                <div class="row">
                    <div class="col-sm-12">
                        <h3></h3>
                        <div class="date-header-btn pull-left form-inline">
                            <div class="btn-group">
                                <button class="btn btn-primary" data-calendar-nav="prev"><< Prev</button>
                                <button class="btn" data-calendar-nav="today">Today</button>
                                <button class="btn btn-primary" data-calendar-nav="next">Next >></button>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-warning active" data-calendar-view="month">Month</button>
                                <button class="btn btn-warning" data-calendar-view="week">Week</button>
                                <button class="btn btn-warning" data-calendar-view="day">Day</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div id="task-calendar-div" class="cal-context"></div>

<?php

$footerContent = '
        <script>
            var calendarView = "'.($_SESSION["calendar_view"] ?? 'month').'"
        </script>

        <!-- Bootstrap Calendar -->
        <script src="'.DIR_PATH.'assets/bootstrap-calendar-master/js/calendar.min.js"></script>

        <script>
            var tmpl_path = "'.DIR_PATH.'assets/bootstrap-calendar-master/tmpls/";
        </script>
        <script src="'.DIR_PATH.'js/task-calendar.js"></script>
';

require dirname(__FILE__)."/includes/footer.php";

?>