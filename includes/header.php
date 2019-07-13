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

        <link rel="manifest" href="manifest.json" />

        <title><?= $pageTitle; ?></title>

        <!-- Font Awesome -->
        <link href="<?= DIR_PATH; ?>assets/font-awesome/css/font-awesome.min.css" media="screen, projection" rel="stylesheet">

        <!-- Sweet Alert -->
        <link href="<?= DIR_PATH; ?>assets/sweetalert-master/dist/sweetalert.css" media="screen, projection" rel="stylesheet">

        <!-- Bootstrap core CSS -->
        <link href="<?= DIR_PATH; ?>assets/bootstrap-4.3.1-dist/css/bootstrap.min.css" rel="stylesheet">

        <link href="assets/household-tasks.css" media="screen, projection" rel="stylesheet">

        <!-- JQuery -->
        <script src="<?= DIR_PATH; ?>assets/jquery/jquery-3.4.1.min.js"></script>

        <!-- underscorejs -->
        <script src="<?= DIR_PATH; ?>assets/underscorejs/underscore-min.js"></script>

        <!-- momentjs -->
        <script src="<?= DIR_PATH; ?>assets/momentjs/moment.min.js"></script>

        <!-- Bootstrap core JavaScript -->
        <script src="<?= DIR_PATH; ?>assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

        <!-- Sweet Alert -->
        <script src="<?= DIR_PATH; ?>assets/sweetalert-master/dist/sweetalert.min.js"></script>

        <?= $headerContent; ?>

    </head>

    <body>

    <nav class="navbar-main-menu navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="task-calendar.php">Household Tasks</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-toggle-button" aria-controls="navbar-toggle-button" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar-toggle-button">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="task-calendar.php">Task Calendar</a></li>
                <li class="nav-item"><a class="nav-link" href="complete-task.php">Complete Task</a></li>
            </ul>
        </div>
    </nav>

        <div class="container">

            <div class="page-header main-page-header">
                <h2><?= $pageTitle; ?></h2>
            </div>