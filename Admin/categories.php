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

        echo "welcome";

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
                        name="Ordering"
                        class="form-control"
                        placeholder="number to arrange he category"/>
                  </div>
              </div>
              <!-- End Ordering Field -->
              <!-- Start Visible Field -->
              <div class="form-group form-group-lg">
                  <label class="col-sm-2 control-label">Visible</label>
                  <div class="col-sm-10 col-md-6">
                      <div>
                          <input id="vis-yes" type="radio" name="visibility" value="0" checked />
                          <label for="vis-yes">Yes</label>
                      </div>
                      <div>
                          <input id="vis-no" type="radio" name="visibility" value="1"/>
                          <label for="vis-no">No</label>
                      </div>
                  </div>
              </div>
              <!-- End Visible Field -->
              <!-- Start Commenting Field -->
              <div class="form-group form-group-lg">
                  <label class="col-sm-2 control-label">Allow Commenting</label>
                  <div class="col-sm-10 col-md-6">
                      <div>
                          <input id="com-yes" type="radio" name="Commenting" value="0" checked />
                          <label for="com-yes">Yes</label>
                      </div>
                      <div>
                          <input id="com-no" type="radio" name="Commenting" value="1"/>
                          <label for="com-no">No</label>
                      </div>
                  </div>
              </div>
              <!-- End Commenting Field -->
              <!-- Start Ads Field -->
              <div class="form-group form-group-lg">
                  <label class="col-sm-2 control-label">Allow Ads</label>
                  <div class="col-sm-10 col-md-6">
                      <div>
                          <input id="ads-yes" type="radio" name="ads" value="0" checked />
                          <label for="ads-yes">Yes</label>
                      </div>
                      <div>
                          <input id="ads-no" type="radio" name="ads" value="1"/>
                          <label for="ads-no">No</label>
                      </div>
                  </div>
              </div>
              <!-- End Ads Field -->
              <!-- Start Submit Field -->
              <div class="form-group form-group-lg">
                  <div class="col-sm-offset-2 col-sm-10">
                      <input type="submit" value="Add member" class="btn btn-primary btn-lg" />
                  </div>
              </div>
              <!-- End Submit Field -->
          </form>
      </div>
    <?
    }elseif ($do == 'insert') {
        // code...

    }elseif ($do == 'edit') {
        // code...

    }elseif ($do == 'update') {
        // code...

    }elseif ($do == 'delete') {
        // code...

    }

    require_once $tplRoute . 'footer.php';

}else {

    header('location: index.php');
    exit();
}

ob_end_flush();
 ?>
