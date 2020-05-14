<?php


/*
**
**Categories Page
**
*/

ob_start();
session_start();
$pageTitle = 'Categories';

if (isset($_SESSION['username'])) {

    require_once 'ini.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage') {

        $sort = 'ASC';

        $sort_array = array('ASC', 'DESC');

        if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {

            $sort = $_GET['sort'];
        }

        $stmt = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
        $stmt->execute();
        $cats = $stmt->fetchAll(); ?>

        <h1 class="text-center">Manage Categories</h1>
        <div class="container categories">
            <div class="card">
              <div class="card-heading">
                  <i class='fa fa-edit'></i>Manage Categories
                  <div class="ordering float-right">
                      <i class="fa fa-sort"></i>Ordering: [
                      <a class="<? if ($sort == 'ASC') { echo 'active'; } ?>" href="?sort=ASC">ASC</a> |
                      <a class="<? if ($sort == 'DESC') { echo 'active'; } ?>" href="?sort=DESC">DESC</a> ]
                  </div>
              </div>
              <div class="card-body">
                  <ul class="list-unstyled latest-users">
                      <?php

                          foreach ($cats as $cat) {

                            echo "<div class='cat'>";
                                  echo "<div class='hidden-button'>";
                                    echo "<a href='categories.php?do=edit&catID=" . $cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
                                    echo "<a href='categories.php?do=delete&catID=" . $cat['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fas fa-times'></i> Delete</a>";
                                  echo "</div>";
                                  echo "<h3>" . $cat['Name'] . "</h3>";
                                  echo '<p>'; if($cat['Description'] == '')  { echo 'This Category has no Description';} else { echo $cat['Description'];} echo '</p>';
                                  if($cat['Visibility'] == 1) {echo '<span class="visibility"><i class="fa fa-eye"></i>Hidden</span>';}
                                  if($cat['AllowCommnet'] == 1) {echo '<span class="commenting"><i class="fas fa-times"></i>Comment Disable</span>';}
                                  if($cat['AllowAds'] == 1) {echo '<span class="advertises"><i class="fas fa-times"></i>Ads Disable</span>';}
                            echo "</div>";
                            echo "<hr />";
                          }
                      ?>
                  </ul>
              </div>
            </div>
            <a class='addcat btn btn-primary' href="categories.php?do=add"><i class="fa fa-plus"></i>Add New Category</a>
        </div>
        <?php

    }elseif ($do == 'add') { // Add Categories Page
    ?>
      <h1 class="text-center">Add New Category</h1>
      <div class="container">
          <form class="form-horizontal" action="?do=insert" method="POST">
              <!-- Start Name Field -->
              <div class="form-group form-group-lg">
                  <label class="col-sm-2 control-label">Category Name</label>
                  <div class="col-sm-10 col-md-6">
                      <input
                        type="text"
                        name="name"
                        class="form-control"
                        placeholder="Name Of The Category"
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
                        placeholder="Descrip the Category"
                        autocomplete="off"/>
                  </div>
              </div>
              <!-- End Description Field -->
              <!-- Start Ordering Field -->
              <div class="form-group form-group-lg">
                  <label class="col-sm-2 control-label">Ordering</label>
                  <div class="col-sm-10 col-md-6">
                      <input
                        type="text"
                        name="ordering"
                        class="form-control"
                        placeholder="number to arrange he category"/>
                  </div>
              </div>
              <!-- End Ordering Field -->
              <!-- Start Visible Field -->
                      <div class="form-group form-group-lg check-cag">
                          <label class="col-sm-2 control-label"> Is Visible</label>
                          <div class="col-sm-10 col-md-2">
                              <div class="float-left">
                                  <input id="vis-yes" type="radio" name="visibility" value="0" checked />
                                  <label for="vis-yes">Yes</label>
                              </div>
                              <div class="float-right">
                                  <input id="vis-no" type="radio" name="visibility" value="1"/>
                                  <label for="vis-no">No</label>
                              </div>
                          </div>
                      </div>
                  <!-- End Visible Field -->
                  <!-- Start Commenting Field -->
                      <div class="form-group form-group-lg check-cag">
                          <label class="col-sm-2 control-label">Allow Commenting</label>
                          <div class="col-sm-10 col-md-2">
                              <div class="float-left">
                                  <input id="com-yes" type="radio" name="commenting" value="0" checked />
                                  <label for="com-yes">Yes</label>
                              </div>
                              <div class="float-right">
                                  <input id="com-no" type="radio" name="commenting" value="1"/>
                                  <label for="com-no">No</label>
                              </div>
                          </div>
                      </div>
              <!-- End Commenting Field -->
              <!-- Start Ads Field -->
              <div class="form-group form-group-lg check-cag ">
                  <label class="col-sm-2 control-label">Allow Ads</label>
                  <div class="col-sm-10 col-md-2">
                      <div class="float-left">
                          <input id="ads-yes" type="radio" name="ads" value="0" checked />
                          <label for="ads-yes">Yes</label>
                      </div>
                      <div class="float-right">
                          <input id="ads-no" type="radio" name="ads" value="1"/>
                          <label for="ads-no">No</label>
                      </div>
                  </div>
              </div>
              <!-- End Ads Field -->
              <!-- Start Submit Field -->
              <div class="form-group form-group-lg">
                  <div class="col-sm-offset-2 col-sm-10">
                      <input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
                  </div>
              </div>
              <!-- End Submit Field -->
          </form>
      </div>
    <?
    }elseif ($do == 'insert') {

        /*
        * Insert Category Page
        */

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          echo "<h1 class='text-center'>Insert Category</h1>";
          echo "<div class='container'>";

          // Get Variables from the Form

          $name     = $_POST['name'];
          $desc     = $_POST['description'];
          $order    = $_POST['ordering'];
          $visible  = $_POST['visibility'];
          $comment  = $_POST['commenting'];
          $ads      = $_POST['ads'];

            // Check if Category exists on not

            $check = checkItem('Name', 'categories', $name );

            if ($check == 1) {

              $theMsg = '<div class="alert alert-danger"> sorry this Category is already token</div>';
              redirectHome($theMsg, 'back');

            }else {

                //inser Category info in databse

                $stmt = $con->prepare('INSERT INTO categories(Name, Description, Visibility, AllowCommnet, AllowAds , Ordering)
                                        VALUES (:zname, :zdesc ,:zvisibale, :zcomment, :zads , :zorder)');


                $stmt->execute([

                    ':zname'       => $name,
                    ':zdesc'       => $desc,
                    ':zvisibale'   => $visible,
                    ':zcomment'    => $comment,
                    ':zads'        => $ads,
                    ':zorder'      => $order

                ]);
                //echo Success Message

                $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Category Inserted </div>';
                redirectHome($theMsg , 'back');
            }

        }else {

          $theMsg = '<div class="alert alert-danger">You can\'t browse this page directly</div>';

          redirectHome($theMsg, 'back');
        }

    }elseif ($do == 'edit') {

          //Check If Get Request CatID is Numeric & Get The Integer Value Of it

        $catID = isset($_GET['catID']) && is_numeric($_GET['catID']) ? intval($_GET['catID']) : 0;

          // Select all Data depend on This ID

        $stmt = $con -> prepare("SELECT * From categories WHERE ID = ? ");

          // Execute Query
        $stmt ->execute(array($catID));

          // Fetch The Data From DataBase
        $cat = $stmt -> fetch();

          //The Row Conut
        $count = $stmt ->rowCount();

          // If There is Sucj ID Show The form
        if($count > 0) { ?>

            <h1 class="text-center">Edit Category</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=update" method="POST">

                    <input type="hidden" name="catID" value="<?php echo $catID ?>">
                    <!-- Start Name Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Category Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input
                              type="text"
                              name="name"
                              class="form-control"
                              placeholder="Name Of The Category"
                              value="<?echo $cat['Name']?>"
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
                              placeholder="Descrip the Category"
                              value="<?echo $cat['Description']?>"/>
                        </div>
                    </div>
                    <!-- End Description Field -->
                    <!-- Start Ordering Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Ordering</label>
                        <div class="col-sm-10 col-md-6">
                            <input
                              type="text"
                              name="ordering"
                              class="form-control"
                              placeholder="number to arrange he category"
                              value="<?echo $cat['Ordering']?>" />
                        </div>
                    </div>
                    <!-- End Ordering Field -->
                    <!-- Start Visible Field -->
                            <div class="form-group form-group-lg check-cag">
                                <label class="col-sm-2 control-label"> Is Visible</label>
                                <div class="col-sm-10 col-md-2">
                                    <div class="float-left">
                                        <input id="vis-yes" type="radio" name="visibility" value="0" <? if ($cat['Visibility'] == 0) { echo 'checked'; } ?> />
                                        <label for="vis-yes">Yes</label>
                                    </div>
                                    <div class="float-right">
                                        <input id="vis-no" type="radio" name="visibility" value="1" <? if ($cat['Visibility'] == 1) { echo 'checked'; } ?>/>
                                        <label for="vis-no">No</label>
                                    </div>
                                </div>
                            </div>
                        <!-- End Visible Field -->
                        <!-- Start Commenting Field -->
                            <div class="form-group form-group-lg check-cag">
                                <label class="col-sm-2 control-label">Allow Commenting</label>
                                <div class="col-sm-10 col-md-2">
                                    <div class="float-left">
                                        <input id="com-yes" type="radio" name="commenting" value="0"  <? if ($cat['AllowCommnet'] == 0) { echo 'checked'; } ?> />
                                        <label for="com-yes">Yes</label>
                                    </div>
                                    <div class="float-right">
                                        <input id="com-no" type="radio" name="commenting" value="1"  <? if ($cat['AllowCommnet'] == 1) { echo 'checked'; } ?>/>
                                        <label for="com-no">No</label>
                                    </div>
                                </div>
                            </div>
                    <!-- End Commenting Field -->
                    <!-- Start Ads Field -->
                    <div class="form-group form-group-lg check-cag ">
                        <label class="col-sm-2 control-label">Allow Ads</label>
                        <div class="col-sm-10 col-md-2">
                            <div class="float-left">
                                <input id="ads-yes" type="radio" name="ads" value="0"  <? if ($cat['AllowAds'] == 0) { echo 'checked'; } ?> />
                                <label for="ads-yes">Yes</label>
                            </div>
                            <div class="float-right">
                                <input id="ads-no" type="radio" name="ads" value="1" <? if ($cat['AllowAds'] == 1) { echo 'checked'; } ?> />
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Ads Field -->
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
            // Show Error Massege If There No ID Such

          }else{

              echo "<div class='container'>";
              $theMsg = '<div class="alert alert-danger">There is no such id</div>';
              redirectHome($theMsg);
              echo "</div>";
          }

    }elseif ($do == 'update') { ?>

        <h1 class='text-center'>Update Category</h1>
        <div class="container">

      <?php

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $id     = $_POST['catID'];
        $name     = $_POST['name'];
        $desc     = $_POST['description'];
        $order    = $_POST['ordering'];
        $visible  = $_POST['visibility'];
        $comment  = $_POST['commenting'];
        $ads      = $_POST['ads'];
          // Update The Database With This Info

          $stmt = $con->prepare("UPDATE
                                    categories
                                SET
                                    name = ?,
                                    description = ?,
                                    ordering = ?,
                                    visibility = ?,
                                    AllowCommnet = ?,
                                    AllowAds = ?
                                WHERE
                                    ID = ? ");
          $stmt->execute(array($name, $desc, $order ,$visible, $comment, $ads, $id));

          // Echo Success Message

          $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Update</div>';

          redirectHome($theMsg);

      }else {

        $theMsg = '<div class="alert alert-danger">You Can\'t Browser This Page Directly</div>';

        redirectHome($theMsg);
      }

      echo "</div>";

  }elseif ($do == 'delete') { ?>

      <h1 class="text-center">Delete Category</h1>
      <div class="container">
        <?
            //Check If Get Request catID is Numeric & Get The Integer Value Of it

          $catID = isset($_GET['catID']) && is_numeric($_GET['catID']) ? intval($_GET['catID']) : 0;

            // Select all Data depend on This ID

          $check = checkItem('ID', 'categories', $catID);

            // If There is Sucj ID Show The form
          if($check > 0) {

            $stmt = $con->prepare('DELETE FROM categories WHERE ID = :zid');
            $stmt->execute([

              'zid' => $catID
            ]);

            if ($stmt->rowCount()) {

                $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Category Delete</div>';

                redirectHome($theMsg,'back');
            }

        }else {

            $theMsg = '<div class="alert alert-warning">Category not exists</div>';

            redirectHome($theMsg);
          }

        echo "</div>";
    }

    require_once $tplRoute . 'footer.php';

}else {

    header('location: index.php');
    exit();
}

ob_end_flush();
 ?>
