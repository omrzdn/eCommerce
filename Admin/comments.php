<?php

/***************
 * *************
 *
 * Manage Comments Page From here by Add And Edite And Delete
 *
 * *************
 **************/

session_start();
$pageTitle = 'Comments';

if (isset($_SESSION['username'])) {

    include 'ini.php';

    if(isset($_GET['do'])){

        $do = $_GET['do'];

    }else{

        $do = "manage";
    }

    //start Manage Page

    if ($do == 'manage') { // Manage Page

        $headline = 'Manage Comments';

      //Select All Comments From Databse

      $stmt = $con->prepare("SELECT
                                comments.* , items.name AS item_name , Users.Username AS user_name
                             FROM
                                comments
                             INNER JOIN
                                items
                             ON
                                items.itemID = comments.itemID
                             INNER JOIN
                                Users
                             ON
                                Users.userID = comments.userID
                             ORDER BY commentID DESC");
      $stmt->execute();
      $rows = $stmt->fetchAll();

    ?>

      <h1 class="text-center"><? echo $headline; ?></h1>
      <div class="container">
        <div class="table-responsive">
          <table class="main-table text-center table table-bordered">
            <tr>
              <td>#ID</td>
              <td style="width: 550px">Comment</td>
              <td>Item Name</td>
              <td>Username</td>
              <td>Added Date</td>
              <td>Control</td>
            </tr>
            <?php

            foreach ($rows as $row) {

              echo '<tr>';

                echo  '<td>'. $row['commentID'] .'</td>';
                echo  '<td>'. $row['comment'].'</td>';
                echo  '<td>'. $row['item_name'].'</td>';
                echo  '<td>'. $row['user_name'].'</td>';
                echo  '<td>'. $row['commentDate'].'</td>';
                echo '<td>
                        <a href="comments.php?do=edit&comID='. $row["commentID"].' "class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                        <a href="comments.php?do=delete&comID='. $row["commentID"].' "class="btn btn-danger confirm"><i class="fas fa-times"></i>Delete</a>';

                    if ($row['status'] == 0) {

                            echo '<a href="comments.php?do=approve&comID='. $row["commentID"].' "class="btn btn-info activate"><i class="fas fa-times"></i>Approve</a>';
                    }
                echo '</td>';
              echo "</tr>";

            }
            ?>
          </table>
        </div>
      </div>
<?
    }elseif($do == 'edit'){ // Edit Page

          //Check If Get Request UserID is Numeric & Get The Integer Value Of it

        $comID = isset($_GET['comID']) && is_numeric($_GET['comID']) ? intval($_GET['comID']) : 0;

          // Select all Data depend on This ID
        $stmt = $con -> prepare("SELECT * From comments WHERE commentID = ? ");

          // Execute Query
        $stmt ->execute(array($comID));

          // Fetch The Data From DataBase
        $row = $stmt -> fetch();

          //The Row Conut
        $count = $stmt ->rowCount();

          // If There is Sucj ID Show The form
        if($count > 0) { ?>

            <h1 class="text-center">Edit Comment</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=update" method="POST">

                    <input type="hidden" name="comID" value="<?php echo $comID ?>">
                    <!-- Start comment Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Comment</label>
                        <div class="col-sm-10 col-md-6">
                            <textarea class="form-control" name="comment" rows="8" cols="80"><?php echo $row['comment'];  ?></textarea>
                        </div>
                    </div>
                    <!-- End comment Field -->
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

              echo "<div class='container'>";
              $theMsg = '<div class="alert alert-danger">There is no such id</div>';
              redirectHome($theMsg);
              echo "</div>";
          }
    }elseif ($do == 'update') { // Update Page ?>

        <h1 class='text-center'>Update Comments</h1>
        <div class="container">

      <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $comID     = $_POST['comID'];
        $comment   = $_POST['comment'];


          // Update The Database With This Info

          $stmt = $con->prepare("UPDATE comments SET comment = ?  WHERE commentID = ? ");
          $stmt->execute(array($comment, $comID));

          // Echo Success Message

          $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Update</div>';

          redirectHome($theMsg);


      }else {

        $theMsg = '<div class="alert alert-danger">You Can\'t Browser This Page Directly</div>';

        redirectHome($theMsg);
      }

      echo "</div>";

  }elseif ($do == 'delete') { //delete comment page ?>

      <h1 class="text-center">Delete Comment</h1>
      <div class="container">
        <?
            //Check If Get Request commentID is Numeric & Get The Integer Value Of it

          $comID = isset($_GET['comID']) && is_numeric($_GET['comID']) ? intval($_GET['comID']) : 0;

            // Select all Data depend on This ID

          $check = checkItem('commentID', 'comments', $comID);

            // If There is Sucj ID Show The form

          if($check > 0) {

            $stmt = $con->prepare('DELETE FROM comments WHERE commentID = :zcom');
            $stmt->execute([

              'zcom' => $comID
            ]);

            if ($stmt->rowCount()) {

                $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Comment Delete</div>';

                redirectHome($theMsg,'back');
            }

        }else {

            $theMsg = '<div class="alert alert-warning">comment not exists</div>';

            redirectHome($theMsg);
          }

        echo "</div>";

    }elseif ($do == 'approve') { //Approve comments Page ?>

        <h1 class="text-center">Approve Comments</h1>
        <div class="container">

          <?
              //Check If Get Request commentID is Numeric & Get The Integer Value Of it

            $comID = isset($_GET['comID']) && is_numeric($_GET['comID']) ? intval($_GET['comID']) : 0;

              // Select all Data depend on This ID

            $check = checkItem('commentID', 'comments', $comID);

              // If There is Sucj ID Show The form
            if($check > 0) {

              $stmt = $con->prepare('UPDATE comments SET status = 1 WHERE commentID = :zcom');
              $stmt->execute([

                'zcom' => $comID
              ]);

              if ($stmt->rowCount()) {

                  $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Comment Approved</div>';

                  redirectHome($theMsg,'back');
              }

          }else {

              $theMsg = '<div class="alert alert-warning">Comment not exists</div>';

              redirectHome($theMsg);
            }

          echo "</div>";

    }


}else{

    header('location: index.php');
    exit();
} ?>
