<?php 

// get the title funcation

function getTitle(){

    global $pageTitle;

    if(isset($pageTitle)){

        echo $pageTitle;
    }else{

        echo 'eCommerce Site';
    }
}