<?php
/*
**
** Items Page
**
*/

ob_start();
session_start();
$pageTitle = 'Items';

if (isset($_SESSION['username'])) {

    require_once 'ini.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';


    if ($do == 'manage') { // Manage Item Page

      //Select All Users From Databse Except Admins
      $headline = 'Manage Items';
      $stmt = $con->prepare("SELECT
                                items.*, categories.Name AS cat_name, Users.Username
                            FROM
                                items
                            INNER JOIN categories ON categories.ID = items.catID
                            INNER JOIN Users ON Users.userID = items.memberID
                            ORDER BY itemID DESC");
      $stmt->execute();
      $items = $stmt->fetchAll();

    ?>

      <h1 class="text-center"><? echo $headline; ?></h1>
      <div class="container">
        <div class="table-responsive">
          <table class="main-table text-center table table-bordered">
            <tr>
              <td>#ID</td>
              <td>Name</td>
              <td>Description</td>
              <td>Price</td>
              <td>Adding Date</td>
              <td>Category</td>
              <td>Username</td>
              <td>Control</td>
            </tr>
            <?php

            foreach ($items as $item) {

              echo '<tr>';

                echo  '<td>'. $item['itemID'] .'</td>';
                echo  '<td>'. $item['name'].'</td>';
                echo  '<td>'. $item['description'].'</td>';
                echo  '<td>'. $item['price'].'</td>';
                echo  '<td>'. $item['addDate'].'</td>';
                echo  '<td>'. $item['cat_name'].'</td>';
                echo  '<td>'. $item['Username'].'</td>';
                echo '<td>
                        <a href="items.php?do=edit&itemID='. $item["itemID"].' "class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                        <a href="items.php?do=delete&itemID='. $item["itemID"].' "class="btn btn-danger confirm"><i class="fas fa-times"></i>Delete</a>';
                        if ($item['approve'] == 0) {

                                echo '<a href="items.php?do=approve&itemID='. $item["itemID"].' "class="btn btn-info activate"><i class="fas fa-check"></i>Approve</a>';
                        }
                echo '</td>';
              echo "</tr>";

            }
            ?>
          </table>
        </div>

        <a href='items.php?do=add' class="btn btn-primary"><i class="fa fa-plus"></i>New Item</a>

      </div>

    <?
}elseif ($do == 'add') { //add item Page
    ?>
          <h1 class="text-center">Add New Item</h1>
          <div class="container items">
              <form class="form-horizontal" action="?do=insert" method="POST">
                  <!-- Start Name Field -->
                  <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Item Name</label>
                      <div class="col-sm-10 col-md-6">
                          <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Name Of The Item"
                            required/>
                      </div>
                  </div>
                  <!-- End Name Field -->
                  <!-- Start Description Field -->
                  <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-10 col-md-6">
                          <input
                            type="text"
                            name="description"
                            class="form-control"
                            placeholder="Description Of The Item"/>
                      </div>
                  </div>
                  <!-- End Description Field -->
                  <!-- Start price Field -->
                  <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">price</label>
                      <div class="col-sm-10 col-md-6">
                          <input
                            type="text"
                            name="price"
                            class="form-control"
                            placeholder="Price Of The Item"
                            required/>
                      </div>
                  </div>
                  <!-- End price Field -->
                  <!-- Start country Field -->
                  <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Country</label>
                      <div class="col-sm-10 col-md-6">
                          <input
                            type="text"
                            name="country"
                            class="form-control"
                            placeholder="Country Of The Item"/>
                      </div>
                  </div>
                  <!-- End country Field -->
                  <!-- Start Status Field -->
                  <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Status</label>
                      <div class="col-sm-10 col-md-6">
                          <select class="form-control" name="status">
                              <option value="0">...</option>
                              <option value="1">New</option>
                              <option value="2">Like New</option>
                              <option value="3">Old</option>
                              <option value="4">Very Old</option>
                          </select>
                      </div>
                  </div>
                  <!-- End Status Field -->
                  <!-- Start members Field -->
                  <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Members</label>
                      <div class="col-sm-10 col-md-6">
                          <select class="form-control" name="members">
                              <option value="0">...</option>
                              <?php
                               $stmt = $con->prepare("SELECT * FROM Users");
                               $stmt->execute();
                               $users = $stmt->fetchAll();
                               foreach ($users as $user) {

                                   echo "<option value='" . $user['userID'] . "'>". $user['FullName'] ."</option>";
                               }
                              ?>
                          </select>
                      </div>
                  </div>
                  <!-- End members Field -->
                  <!-- Start category Field -->
                  <div class="form-group form-group-lg">
                      <label class="col-sm-2 control-label">Category</label>
                      <div class="col-sm-10 col-md-6">
                          <select class="form-control" name="categories">
                              <option value="0">...</option>
                              <?php
                               $stmt = $con->prepare("SELECT * FROM categories");
                               $stmt->execute();
                               $cats = $stmt->fetchAll();
                               foreach ($cats as $cat) {

                                   echo "<option value='" . $cat['ID'] . "'>". $cat['Name'] ."</option>";
                               }
                              ?>
                          </select>
                      </div>
                  </div>
                  <!-- End category Field -->
                  <!-- Start Submit Field -->
                  <div class="form-group form-group-lg">
                      <div class="col-sm-offset-2 col-sm-10">
                          <input type="submit" value="Add Item" class="itembtn btn btn-primary" />
                      </div>
                  </div>
                  <!-- End Submit Field -->
              </form>
          </div>
        <?
    }elseif ($do == 'insert') { //insert items Page

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          echo "<h1 class='text-center'>Insert Item</h1>";
          echo "<div class='container'>";

          $name          = $_POST['name'];
          $description   = $_POST['description'];
          $price         = $_POST['price'];
          $country       = $_POST['country'];
          $status        = $_POST['status'];
          $member        = $_POST['members'];
          $categories    = $_POST['categories'];

          //validte the form

          $formErrors = array();

          //empty($user) ? $formErrors[] = 'Username Can\'t be empty';

          if (empty($name)) {

            $formErrors[] = 'Name Can\'t be <strong>empty</strong>';
          }

          if (empty($price)) {

            $formErrors[] = 'price Can\'t be <strong>empty</strong>';
          }

          if (empty($country)) {

            $formErrors[] = 'Country can\'t be empty';
          }

          if ($status == 0) {

            $formErrors[] = 'You must Descrip status of <strong>'. $name .'</strong> item';
          }

          if ($member == 0) {

            $formErrors[] = 'You must choose member for <strong>'. $name .'</strong> item';
          }

          if ($categories == 0) {

            $formErrors[] = 'You must choose category for this <strong>'. $name .'</strong> item';
          }

          foreach ($formErrors as $error) {

            echo '<div class="alert alert-danger">' . $error . '</div>';
          }

          if (empty($formErrors)) {


              // Insert user info in database

              $stmt = $con->prepare("INSERT INTO
                                        items(name, description, price, countryMade, status, addDate, catID, memberID)
                                     VALUES
                                        (:zname, :zdescription, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember )");

              $stmt->execute([

                'zname'        => $name,
                'zdescription' => $description,
                'zprice'       => $price,
                'zcountry'     => $country,
                'zstatus'      => $status,
                'zcat'         => $categories,
                'zmember'      => $member

              ]);
              // Echo Success Message

              $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' item Inserted</div>';

              redirectHome($theMsg);

          }

        }else {

          $theMsg = '<div class="alert alert-danger">You can\'t browse this page directly</div>';

          redirectHome($theMsg, 'back');
        }

    }elseif ($do == 'edit') { // Edit Item Page

          //Check If Get Request UserID is Numeric & Get The Integer Value Of it

        $itemID = isset($_GET['itemID']) && is_numeric($_GET['itemID']) ? intval($_GET['itemID']) : 0;

          // Select all Data depend on This ID
        $stmt = $con -> prepare("SELECT * From items WHERE itemID = ? ");

          // Execute Query
        $stmt ->execute(array($itemID));

          // Fetch The Data From DataBase
        $item = $stmt -> fetch();

          //The Row Conut
        $count = $stmt ->rowCount();

          // If There is Sucj ID Show The form
        if($count > 0) { ?>

            <h1 class="text-center">Edit Item</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=update" method="POST">
                    <input type="hidden" name="itemID" value="<?php echo $itemID ?>">
                    <!-- Start Name Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Item Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input
                              type="text"
                              name="name"
                              class="form-control"
                              placeholder="Name Of The Item"
                              value="<? echo $item['name']; ?>"
                              required/>
                        </div>
                    </div>
                    <!-- End Name Field -->
                    <!-- Start Description Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                            <input
                              type="text"
                              name="description"
                              class="form-control"
                              placeholder="Description Of The Item"
                              value="<? echo $item['description']; ?>"/>
                        </div>
                    </div>
                    <!-- End Description Field -->
                    <!-- Start price Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">price</label>
                        <div class="col-sm-10 col-md-6">
                            <input
                              type="text"
                              name="price"
                              class="form-control"
                              placeholder="Price Of The Item"
                              required
                              value="<? echo $item['price']; ?>"/>
                        </div>
                    </div>
                    <!-- End price Field -->
                    <!-- Start country Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-10 col-md-6">
                            <input
                              type="text"
                              name="country"
                              class="form-control"
                              placeholder="Country Of The Item"
                              value="<? echo $item['countryMade']; ?>"/>
                        </div>
                    </div>
                    <!-- End country Field -->
                    <!-- Start Status Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10 col-md-6">
                            <select class="form-control" name="status">
                                <option value="1" <? if($item['status'] == 1) {echo "selected";} ?> >New</option>
                                <option value="2" <? if($item['status'] == 2) {echo "selected";} ?> >Like New</option>
                                <option value="3" <? if($item['status'] == 3) {echo "selected";} ?> >Old</option>
                                <option value="4" <? if($item['status'] == 4) {echo "selected";} ?> >Very Old</option>
                            </select>
                        </div>
                    </div>
                    <!-- End Status Field -->
                    <!-- Start members Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Members</label>
                        <div class="col-sm-10 col-md-6">
                            <select class="form-control" name="members">
                                <?php
                                 $stmt = $con->prepare("SELECT * FROM Users");
                                 $stmt->execute();
                                 $users = $stmt->fetchAll();
                                 foreach ($users as $user) {

                                     echo "<option value='" . $user['userID'] . "'"; if($item['memberID'] == $user['userID']) {echo "selected";} echo " >". $user['FullName'] ."</option>";
                                 }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End members Field -->
                    <!-- Start category Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10 col-md-6">
                            <select class="form-control" name="categories">
                                <?php
                                 $stmt = $con->prepare("SELECT * FROM categories");
                                 $stmt->execute();
                                 $cats = $stmt->fetchAll();
                                 foreach ($cats as $cat) {

                                    echo "<option value='" . $cat['ID'] . "'";
                                    if($item['catID'] == $cat['ID']) {echo "selected";}
                                    echo ">". $cat['Name'] ."</option>";
                                 }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End category Field -->
                    <!-- Start Submit Field -->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Save Item" class="itembtn btn btn-primary" />
                        </div>
                    </div>
                    <!-- End Submit Field -->
                </form>
                <?
                /*
                **
                ** Start manage Comment on Item page
                **
                */

                $headline = 'Manage [ '. $item['name'] .' ] Comments';

                  //Select All Users From Databse Except Admins

                  $stmt = $con->prepare("SELECT
                                            comments.* , Users.Username AS user_name
                                         FROM
                                            comments
                                         INNER JOIN
                                            Users
                                         ON
                                            Users.userID = comments.userID
                                         WHERE
                                            itemID = $itemID");
                  $stmt->execute();
                  $rows = $stmt->fetchAll();

                  if (!empty($rows)) {

                ?>

                    <h1 class="text-center"><? echo $headline; ?></h1>
                    <div class="table-responsive">
                      <table class="main-table text-center table table-bordered">
                        <tr>
                          <td>Comment</td>
                          <td>Username</td>
                          <td>Added Date</td>
                          <td>Control</td>
                        </tr>
                        <?php

                        foreach ($rows as $row) {

                          echo '<tr>';
                            echo  '<td>'. $row['comment'].'</td>';
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
                <? } ?>
                </div>
        <?PHP

            // Show Error Massege If There No ID Such

          }else{

              echo "<div class='container'>";
              $theMsg = '<div class="alert alert-danger">There is no such id</div>';
              redirectHome($theMsg);
              echo "</div>";
          }

    }elseif ($do == 'update') { //update Item Page

        ?>
            <h1 class='text-center'>Update Item</h1>
            <div class="container">
          <?php

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id          = $_POST['itemID'];
            $name        = $_POST['name'];
            $desc        = $_POST['description'];
            $price       = $_POST['price'];
            $country     = $_POST['country'];
            $status      = $_POST['status'];
            $member      = $_POST['members'];
            $categories  = $_POST['categories'];

            //validte the form

              $formErrors = array();

              //empty($user) ? $formErrors[] = 'Username Can\'t be empty';

              if (empty($name)) {

                $formErrors[] = 'Name Can\'t be <strong>empty</strong>';
              }

              if (empty($price)) {

                $formErrors[] = 'price Can\'t be <strong>empty</strong>';
              }

              if (empty($country)) {

                $formErrors[] = 'Country can\'t be empty';
              }

              if ($status == 0) {

                $formErrors[] = 'You must Descrip status of <strong>'. $name .'</strong> item';
              }

              if ($member == 0) {

                $formErrors[] = 'You must choose member for <strong>'. $name .'</strong> item';
              }

              if ($categories == 0) {

                $formErrors[] = 'You must choose category for this <strong>'. $name .'</strong> item';
              }

            foreach ($formErrors as $error) {

              echo '<div class="alert alert-danger">' . $error . '</div>';
            }

            if (empty($formErrors)) {

              // Update The Database With This Info

              $stmt = $con->prepare("UPDATE
                                        items
                                     SET
                                        name = ?,
                                        description = ?,
                                        price = ?,
                                        status = ?,
                                        countryMade = ?,
                                        memberID = ?,
                                        catID = ?
                                     WHERE
                                        itemID = ? ");
              $stmt->execute(array($name, $desc, $price, $status, $country, $member, $categories, $id));

              // Echo Success Message

              $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Update</div>';

              redirectHome($theMsg);

            }

          }else {

            $theMsg = '<div class="alert alert-danger">You Can\'t Browser This Page Directly</div>';

            redirectHome($theMsg);
          }

          echo "</div>";

    }elseif ($do == 'delete') { // delete item page

    ?>
      <h1 class="text-center">Delete Item</h1>
      <div class="container">
        <?
            //Check If Get Request UserID is Numeric & Get The Integer Value Of it

          $itemID = isset($_GET['itemID']) && is_numeric($_GET['itemID']) ? intval($_GET['itemID']) : 0;

            // Select all Data depend on This ID

          $check = checkItem('itemID', 'items', $itemID);

            // If There is Sucj ID Show The form
          if($check > 0) {

            $stmt = $con->prepare('DELETE FROM items WHERE itemID = :zitem');
            $stmt->execute([

              'zitem' => $itemID
            ]);

            if ($stmt->rowCount()) {

                $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Item Delete</div>';

                redirectHome($theMsg,'back');
            }

        }else {

            $theMsg = '<div class="alert alert-warning">User not exists</div>';

            redirectHome($theMsg);
          }

        echo "</div>";

    }elseif ($do == 'approve') { // approve item page ?>


        <h1 class="text-center">Approve Item</h1>
        <div class="container">
          <?
              //Check If Get Request itemID is Numeric & Get The Integer Value Of it

            $itemID = isset($_GET['itemID']) && is_numeric($_GET['itemID']) ? intval($_GET['itemID']) : 0;

              // Select all Data depend on This ID

            $check = checkItem('itemID', 'items', $itemID);

              // If There is Sucj ID Show The form

            if($check > 0) {

              $stmt = $con->prepare('UPDATE items SET approve = 1 WHERE itemID = :zitemID');
              $stmt->execute([

                'zitemID' => $itemID

              ]);

              if ($stmt->rowCount()) {

                  $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Item Approved</div>';

                  redirectHome($theMsg,'back');
              }

          }else {

              $theMsg = '<div class="alert alert-warning">Item not exists</div>';

              redirectHome($theMsg);
            }

          echo "</div>";
    }

    require_once $tplRoute . 'footer.php';

}else{

    header('location: index.php');
    exit();
}

ob_end_flush();
?>
