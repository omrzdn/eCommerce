<?php 

    session_start();

    
    if (isset($_SESSION['username'])) {
        
        $pageTitle = 'Dashboard Page';
        
        include 'ini.php';

        echo "Hello World";
    }else {
        
        header('location: index.php');
        exit();
    }