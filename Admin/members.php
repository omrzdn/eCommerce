<?php

/***************
 * *************
 * 
 * Manage Member Page From here by Add And Edite And Delete
 * 
 * *************
 **************/

session_start();

if (isset($_SESSION['username'])) {
    
    include 'ini.php';

    if(isset($_GET['do'])){
     
        $do = $_GET['do'];
    
    }else{
    
        $do = "manage";
    }
    
    //start Manage Page

    if ($do == 'manage') { // Manage Page

        echo 'this is manage page';

    }elseif($do == 'edit'){ // Edit Page 
    
    $userID = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;
    $stmt = $con -> prepare("SELECT * From Users WHERE userID = ?  LIMIT = 1");
    $stmt ->execute(array($userID));
    $row = $stmt -> fetch();
    $count = $stmt ->rowCount();

    if($count > 0) { ?>

        <h1 class="text-center">Edit Member</h1>
        <div class="container">
            <form class="form-horizontal">
                <!-- Start Username Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="username"  value="<?php echo $row['username'];  ?>" class="form-control" autocomplete="off"/>
                    </div>
                </div>
                <!-- End Username Field -->
                <!-- Start Password Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="password" name="password" class="password form-control" autocomplete="new-password"/>
                    </div>
                </div>
                <!-- End Password Field -->
                <!-- Start Email Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="email" name="email" value="<?php echo $row['Email'];  ?>" class="form-control"/>
                    </div>
                </div>
                <!-- End Email Field -->
                <!-- Start Full Name Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="full" value="<?php echo $row['FullName'];  ?>" class="form-control"/>
                    </div>
                </div>
                <!-- End Full Name Field -->
                <!-- Start Submit Field -->
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Save" class="btn btn-primary btn-lg" />
                    </div>
                </div>
                <!-- End Submit Field -->
            </form>
        </div>
    <?PHP
    }else{

        echo 'No Member With This Name';
    }
}
    include $tplRoute . "footer.php";   

}else{
    
    header('location: index.php');
    exit();
}

?>