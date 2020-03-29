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

      //Check If Get Request UserID is Numeric & Get The Integer Value Of it

    $userID = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;

      // Select all Data depend on This ID
    $stmt = $con -> prepare("SELECT * From Users WHERE userID = ?  LIMIT 1");

      // Execute Query
    $stmt ->execute(array($userID));

      // Fetch The Data From DataBase
    $row = $stmt -> fetch();

      //The Row Conut
    $count = $stmt ->rowCount();

      // If There is Sucj ID Show The form
    if($count > 0) { ?>

        <h1 class="text-center">Edit Member</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=update" method="POST">

                <input type="hidden" name="userID" value="<?php echo $userID ?>">
                <!-- Start Full Name Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="full" value="<?php echo $row['FullName'];  ?>" class="form-control"/>
                    </div>
                </div>
                <!-- End Full Name Field -->
                <!-- Start Username Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="username"  value="<?php echo $row['Username'];  ?>" class="form-control" autocomplete="off"/>
                    </div>
                </div>
                <!-- End Username Field -->
                <!-- Start Email Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="email" name="email" value="<?php echo $row['Email'];  ?>" class="form-control"/>
                    </div>
                </div>
                <!-- End Email Field -->
                <!-- Start Password Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="hidden" name="oldpassword" value="<? echo $row['Password'];?>"/>
                        <input type="password" name="newpassword" class="password form-control" autocomplete="new-password"/>
                    </div>
                </div>
                <!-- End Password Field -->
                <!-- Start Submit Field -->
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Save Change" class="btn btn-primary btn-lg" />
                    </div>
                </div>
                <!-- End Submit Field -->
            </form>
        </div>
      <?PHP

        // Show Error Massege If There No ID Such

      }else{

          echo 'No Member With This ID Number';
      }
    }elseif ($do == 'update') { // Update Page ?>

      <h1 class='text-center'>Update Page</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $id     = $_POST['userID'];
      $user   = $_POST['username'];
      $email  = $_POST['email'];
      $name   = $_POST['full'];

      // Update The Database With This Info

      $stmt = $con->prepare("UPDATE Users SET Username = ?, Email = ?, FullName = ? WHERE UserID = ? ");
      $stmt->execute(array($user, $email, $name, $id));

      // Echo Success Message

      echo $stmt->rowCount() . ' Record Update';

    }else {

      echo "You Can\'t Browser This Page Directly";
    }


    }


    include $tplRoute . "footer.php";

}else{

    header('location: index.php');
    exit();
}

?>
