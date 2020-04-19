<?php

    ob_start();

    session_start();


    if (isset($_SESSION['username'])) {

        $pageTitle = 'Dashboard Page';

        include 'ini.php';

        /**
        *** Start Dashboard Page
        **/

        $latestUsers = 5;
        $thelatest = getLatest('*', 'Users', 'UserID', $latestUsers);


        ?>
        <div class="container home-stats text-center">
          <h1>Dashboard</h1>
          <div class="row">
            <div class="col-md-3">
              <div class="stat st-members">
                Total Members
                <span> <a href="members.php"><? echo (countItem('UserID', 'Users') - 1); ?></a> </span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="stat st-pending">
                Pending Members
                <span><a href="members.php?do=manage&page=pending"><? echo checkItem("RegStatus", 'Users', 0);?></a></span>
              </div>
            </div>
            <div class="col-md-3 ">
              <div class="stat st-items">
                Total Items
                <span>44</span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="stat st-comments">
                Total Comment
                <span>517</span>
              </div>
            </div>
          </div>
        </div>
        <!-- Start Latest Section -->
        <div class="latest">
            <div class="container">
              <div class="row">
                <div class="col-sm-6">
                  <div class="card">
                    <div class="card-heading">
                      <i class="card-title fa fa-users"></i> Latest <? echo $latestUsers; ?> Registerd Users
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled latest-users">
                            <?php

                                foreach ($thelatest as $user) {

                                    echo '<li>' . $user['FullName'] ;
                                    echo    '<a href="members.php?do=edit&userID='. $user['userID'].'"><span class="btn btn-success float-right">';
                                    echo        '<i class="fa fa-edit"></i>Edit';
                                    echo    '</span></a>';
                                    echo '</li>';
                                }
                            ?>
                        </ul>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="card">
                    <div class="card-heading">
                      <i class="card-title fa fa-tag"></i> Latest Items
                    </div>
                    <div class="card-body">
                      test
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <?
    }else {

        header('location: index.php');
        exit();
    }

    ob_end_flush();
?>
