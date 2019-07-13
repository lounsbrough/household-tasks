<?php

$pageTitle = "Complete Task";

define('DIR_PATH', '');

$headerContent = '';
require dirname(__FILE__).'/includes/header.php';

if (isset($_GET["person_key"])) {
    $_SESSION["person_key"] = $_GET["person_key"];
}

require_once dirname(__FILE__).'/classes/database.php';
$database = new Database();

$query = "
SELECT 
    *
FROM
    definedtasks
ORDER BY TaskName;
";

$definedTasks = $database->getResultSet($query);

$taskOptions = '';
foreach ($definedTasks as $definedTask)
{
    $optionSelected = ($_GET["task_key"] ?? '') == $definedTask["TaskKey"] ? 'selected' : '';
    $taskOptions .= '<option '.$optionSelected.' value="'.$definedTask["TaskKey"].'">'.$definedTask["TaskName"].'</option>';
}

$query = "
SELECT 
    *
FROM
    persons
ORDER BY FirstName;
";

$definedPersons = $database->getResultSet($query);

$personOptions = '';
foreach ($definedPersons as $definedPerson)
{
    $optionSelected = ($_SESSION["person_key"] ?? '') == $definedPerson["PersonKey"] ? 'selected' : '';
    $personOptions .= '<option '.$optionSelected.' value="'.$definedPerson["PersonKey"].'">'.$definedPerson["FirstName"].'</option>';
}

$snoozeAmountOptions = '';
for ($i = 1; $i <= 60; $i++) {
    $snoozeAmountOptions .= '<option>'.$i.'</option>';
}

?>

<form id="task-details-form">

    <br>
    <div class="row">

        <h3 class="col-md-12" style="font-size:20px">
            Task: 
            <select id="select-task" name="task_key">
                <?= $taskOptions ?>
            </select>
        </h3>

    </div><br>
    <div class="row">

        <div class="col-md-12">
            Completed By: 
            <select id="select-person" name="person_key">
                <?= $personOptions ?>
            </select>
        </div>

    </div><br>            
    <div class="row">

        <div class="col-md-12 task-action-div">
            <i id="fa-task-complete" class="fa-task-option fa fa-green fa-3x fa-check-circle-o cursor-pointer fa-vcenter fa-selected"></i>
            <span style="font-size:20px">
                <input type="datetime-local" name="completed_tms" value="<?php echo date("Y-m-d\TH:i"); ?>" style="max-width:70%" />
            </span>
        </div>

    </div><br>
    <div class="row">

        <div class="col-md-12 task-action-div">
            <i id="fa-task-snooze-for" class="fa-task-option fa fa-yellow fa-3x fa-clock-o cursor-pointer fa-vcenter fa-unselected"></i>
            <span style="font-size:20px">
                <select disabled name="snooze_amount" style="opacity:0.3">
                    <?= $snoozeAmountOptions ?>
                </select>
                <select disabled name="snooze_type" style="opacity:0.3">
                    <option>minutes</option>
                    <option>hours</option>
                    <option selected>days</option>
                </select>
            </span>
        </div>

    </div><br>
    <div class="row">
            
        <div class="col-md-12 task-action-div">
            <i id="fa-task-snooze-until" class="fa-task-option fa fa-yellow fa-3x fa-clock-o cursor-pointer fa-vcenter fa-unselected"></i>
            <span style="font-size:20px">
                <input disabled name="snooze_until" type="datetime-local" value="<?php echo date("Y-m-d\TH:i",strtotime("+1 days")); ?>" style="max-width:70%;opacity:0.3" />
            </span>
        </div>
    </div><br><br>
    <div class="row">
            
        <div class="col-md-12">
            <button id="task-action-button" type="button" class="btn btn-success btn-lg btn-block">Complete <i class="fa fa-check"></i></button>
        </div>
    </div><br>

</form>

<?php

$footerContent = '

<script src="'.DIR_PATH.'js/complete-task.js"></script>

';

require dirname(__FILE__)."/includes/footer.php";

if (isset($_GET["task_key"])) {
    $query = "
    SELECT 
        CompletedTMS, FirstName
    FROM
        definedtasks,
        completedtasks,
        persons
    WHERE
        definedtasks.TaskKey = completedtasks.TaskKey
            AND completedtasks.PersonKey = persons.PersonKey
            AND completedtasks.TaskKey = :taskkey
            AND CompletedTMS > DATE_ADD(NOW(),
            INTERVAL - 24 HOUR)
            AND NextOccurrenceTMS > NOW()
    ORDER BY CompletedTMS DESC
    LIMIT 1
    ";

    $parameters = array(
        array('name' => ':taskkey', 'value' => $_GET["task_key"])
    );

    $results = $database->getResultSet($query, $parameters);

    if (!empty($results))
    {
?>
    <script>
        $(function() {
            swal({
                title: "Task Already Complete",
                text: "This task was completed by <?= trim($results[0]["FirstName"]) ?>",
                type: "success"
            });
            $(".sweet-alert .sa-icon.sa-success").css({"border-color":"#5cb85c"});
            $(".sweet-alert .sa-icon.sa-success .sa-line").css({"background-color":"#5cb85c"});
            $(".sweet-alert .sa-icon.sa-success .sa-placeholder").css({"border":"4px solid rgba(92,184,92,0.5)"});
        });
    </script>
<?php
    }
}
?>