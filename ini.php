<?php

    //error Reporting

    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    // includes Files

    include 'Admin/connect.php';

    $sessionUser = '';
    if (isset($_SESSION['user'])) {

        $sessionUser = $_SESSION['user'];
    }

    //Routes

    $cssRoute   = 'layout/css/';
    $jsRoute    = 'layout/js/';
    $tplRoute   = 'includes/templates/';
    $langsRoute = 'includes/langs/';
    $funcRoute  = 'includes/functions/';

    //including The Important Files
    include $funcRoute  . 'function.php';
    include $langsRoute . 'english.php';
    include $tplRoute   . 'header.php';
