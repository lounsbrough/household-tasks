<?php

define("DIR_PATH","");
define("TOP_LEVEL_PATH",DIR_PATH."../");

$pageTitle = "Complete Task";

$headerContent = '';
require DIR_PATH."includes/header.php";

if (isset($_GET["person_key"])) {
    $_SESSION["person_key"] = $_GET["person_key"];
}

?>

            <form id="task-details-form">

                <br>
                <div class="row">

                    <h3 class="col-md-12" style="font-size:20px">
                        Task: <select id="select-task" name="task_key">

<?php

$householdConnection = new PDO("mysql:host=localhost;port=3306;dbname=householdtasks", getenv('MYSQL_DB_USERNAME'), getenv('MYSQL_DB_PASSWORD'));

$query = "Select *
          From   definedtasks
          Order By TaskName";

if ($sql = $householdConnection->query($query)) {
    while ($result = $sql->fetch()) {
        echo '<option '.(isset($_GET["task_key"]) && $_GET["task_key"] == $result["TaskKey"] ? 'selected' : '').' value="'.$result["TaskKey"].'">'.$result["TaskName"].'</option>';
    }
}

?>

                        </select>
                    </h3>

                </div><br>
                <div class="row">

                    <div class="col-md-12">
                        Completed By: <select id="select-person" name="person_key">

<?php

$householdConnection = new PDO("mysql:host=localhost;port=3306;dbname=householdtasks", getenv('MYSQL_DB_USERNAME'), getenv('MYSQL_DB_PASSWORD'));

$query = "Select *
          From   persons
          Order By FirstName";

if ($sql = $householdConnection->query($query)) {
    while ($result = $sql->fetch()) {
        $optionSelected = '';
        if (isset($_GET["person_key"])) {
            if ($_GET["person_key"] == $result["PersonKey"]) {
                $optionSelected = 'selected';
            }
        } else if (isset($_SESSION["person_key"])) {
            if ($_SESSION["person_key"] == $result["PersonKey"]) {
                $optionSelected = 'selected';
            }
        }
        echo '<option '.$optionSelected.' value="'.$result["PersonKey"].'">'.$result["FirstName"].'</option>';
    }
}

?>

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
<?php
for ($i=1;$i<=60;$i++) {
    echo '<option>'.$i.'</option>';
}
?>
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

<script src="js/complete-task.js"></script>

';

if (isset($_GET["task_key"])) {

    $query = "Select CompletedTMS, FirstName
              From   definedtasks, completedtasks, persons
              Where  definedtasks.TaskKey = completedtasks.TaskKey
              And    completedtasks.PersonKey = persons.PersonKey
              And    completedtasks.TaskKey = ".$_GET["task_key"]."
              And    CompletedTMS > Date_Add(Current_Timestamp,INTERVAL - 24 hour)
              And    NextOccurrenceTMS > Current_Timestamp
              Order By CompletedTMS Desc
              Limit 1";

    if ($sql = $householdConnection->query($query)) {
        if ($result = $sql->fetch()) {
            $footerContent .= '<script>
                                   $(function() {
                                       swal({
                                           title: "Task Already Complete",
                                           text: "This task was completed by '.trim($result["FirstName"]).'",
                                           type: "success"
                                       });
                                       $(".sweet-alert .sa-icon.sa-success").css({"border-color":"#5cb85c"});
                                       $(".sweet-alert .sa-icon.sa-success .sa-line").css({"background-color":"#5cb85c"});
                                       $(".sweet-alert .sa-icon.sa-success .sa-placeholder").css({"border":"4px solid rgba(92,184,92,0.5)"});
                                   });
                               </script>';
        }
    }

}

require DIR_PATH."includes/footer.php";

?>