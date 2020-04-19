<?php

    // includes Files

    include 'connect.php';

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

    //including navbar on all pages expect the one With $noNavbar Vairable

    if(!isset($noNavbar)){include $tplRoute . 'navbar.php';}
