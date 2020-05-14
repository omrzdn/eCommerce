<?php

/**
*** Get All Function v1.0
*** Function to Get all recorders from any database table
**/

function getAllFrom($tablename, $order = null){

    global $con;

    $getAll = $con->prepare("SELECT * FROM $tablename ORDER BY $order DESC");

    $getAll->execute();

    $all = $getAll->fetchAll();

    return $all;

}

/**
*** Get Records Function v1.0
*** Function to Get Categories from database
**/

function getCat(){

    global $con;

    $getCat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");

    $getCat->execute();

    $cats = $getCat->fetchAll();

    return $cats;

}

/**
*** Get Items Function v1.0
*** Function to Get Items from database
**/

function getItems($where, $value){

    global $con;

    $getItems = $con->prepare("SELECT * FROM items WHERE $where = ? ORDER BY itemID DESC");

    $getItems->execute(array($value));

    $items = $getItems->fetchAll();

    return $items;

}

// get Page title funcation

function getTitle(){

    global $pageTitle;

    if(isset($pageTitle)){

        echo $pageTitle;
    }else{

        echo 'eCommerce Site';
    }
}

/**
*** Check if user not activate Function v1.0
*** Function to to check regStatue in database
**/

function checkUserStatus($user){

    global $con;
    $stmtx = $con->prepare("SELECT
                                Username, RegStatus
                            FROM
                                Users
                            WHERE
                                Username = ?
                            AND
                                RegStatus = 0 ");
    $stmtx->execute(array($user));
    $status = $stmtx->rowCount();

    return $status;
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
