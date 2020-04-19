<?php

// get Page title funcation

function getTitle(){

    global $pageTitle;

    if(isset($pageTitle)){

        echo $pageTitle;
    }else{

        echo 'eCommerce Site';
    }
}


// Redirect function

function redirectHome($theMsg, $url = NULL , $seconds = 3){


  if ($url === NULL) {

    $url  = 'index.php';
    $link = 'HomePage';

  }else {

    if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !=='' ) {

      $url  = $_SERVER['HTTP_REFERER'];
      $link = 'previous Page';
    }else {

      $url = 'index.php';
    }

  }

  echo $theMsg;

  echo "<div class='alert alert-info'>You will be redirected to $link after $seconds Seconds.</div>";

  header("refresh: $seconds;url=$url");

  exit();

}


/**
*** Check Item Function
*** Function to check item in database
**/

function checkItem($select, $from, $value){

  global $con;

  $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

  $statement->execute(array($value));

  $count = $statement->rowCount();

  return $count;
}

/**
*** Calculate Item Function
*** Function to Count item in database
**/

function countItem($item, $table){

    global $con;

    $stmtItem = $con->prepare("SELECT COUNT($item) FROM $table");
    $stmtItem->execute();

    return $stmtItem->fetchColumn();
}


/**
*** Get Latest Records Function
*** Function to Get Latest item from database
**/

function getLatest($select, $table, $order, $limit = 5){

    global $con;

    $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

    $getStmt->execute();

    $rows = $getStmt->fetchAll();

    return $rows;

}
