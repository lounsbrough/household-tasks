<?php

ini_set('session.cookie_lifetime',3600*24*30);
session_name("household_tasks");
session_start();
session_regenerate_id();

?>

<!DOCTYPE html>

<html>

    <head profile="http://www.w3.org/2005/10/profile">

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Household Tasks">
        <meta name="author" content="David Lounsbrough">

        <link rel="icon" type="image/png" href="favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" href="favicon/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="favicon/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="favicon/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="favicon/favicon-192x192.png" sizes="192x192">
        <link rel="shortcut icon" href="favicon/favicon.ico">

        <title><?php echo $pageTitle; ?></title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo DIR_PATH; ?>assets/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="<?php echo DIR_PATH; ?>assets/bootstrap-3.3.6-dist/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- Font Awesome -->
        <link href="<?php echo DIR_PATH; ?>assets/font-awesome/css/font-awesome.min.css" media="screen, projection" rel="stylesheet">

        <!-- Sweet Alert -->
        <link href="<?php echo DIR_PATH; ?>assets/sweetalert-master/dist/sweetalert.css" media="screen, projection" rel="stylesheet">

        <link href="assets/household-tasks.css" media="screen, projection" rel="stylesheet">

        <?php echo $headerContent; ?>

    </head>

    <body>

        <nav class="navbar navbar-default">

            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="task-calendar.php">Task Calendar</a></li>
                        <li class="active"><a href="complete-task.php">Complete Task</a></li>
                    </ul>
                </div>
            </div>

        </nav>

        <div class="container">

            <div class="page-header main-page-header">
                <h2><?php echo $pageTitle; ?></h2>
            </div>