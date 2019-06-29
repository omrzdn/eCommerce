<?php

$do = '';

if(isset($_GET['do'])){
     
    $do = $_GET['do'];

}else{

    $do = "manage";
}

// If The Page is Main Page 

if( $do == 'manage'){

    echo "Welcome You Are Now in Manage Section Page" . '<br />';
    echo "<a href='?do=add'>Add New Section +</a>" . '<br />';
    echo "<a href='?do=insert'>Insert Section *</a>" . '<br />';
    echo "<a href='?do=delete'>Delete Section -</a>" . '<br />';

}elseif($do== "add"){

    echo "Welcome You Are Now in Add New Section Page";

}elseif($do== "insert"){

    echo "Welcome You Are Now in insert Section Page";

}elseif($do== "delete"){

    echo "Welcome You Are Now in Delete Section Page";

}else{

    echo "There\'s No Page With This Name";
}