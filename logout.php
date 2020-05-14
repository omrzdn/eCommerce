<?php 

    session_start(); // resume Session There is Start in index page
    
    session_unset(); // Unset Session without Destroy

    session_destroy(); // Destroy the Session 

    header('location: index.php');

    exit();