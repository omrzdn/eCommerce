<?php

    ob_start();

    session_start();


    if (isset($_SESSION['username'])) {

        $pageTitle = 'Dashboard Page';

        include 'ini.php';

        /**
        *** Start Dashboard Page
        **/

        $numUsers = 5;
        $latestsUsers = getLatest('*', 'Users', 'UserID', $numUsers);

        $numItems = 5;
        $latestsitems = getLatest('*', 'items', 'itemID', $numItems);

        $numComments = 4;

        ?>
        <div class="container home-stats text-center">
          <h1>Dashboard</h1>
          <div class="row">
            <div class="col-md-3">
              <div class="stat st-members">
                  <i class="fa fa-users"></i>
                  <div class="info">
                      Total Members
                      <span> <a href="members.php"><? echo (countItem('UserID', 'Users') - 1); ?></a> </span>
                  </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="stat st-pending">
                  <i class="fa fa-user-plus"></i>
                  <div class="info">
                      Pending Members
                      <span><a href="members.php?do=manage&page=pending"><? echo checkItem("RegStatus", 'Users', 0);?></a></span>
                  </div>
              </div>
            </div>
            <div class="col-md-3 ">
              <div class="stat st-items">
                  <i class='fas fa-tags'></i>
                  <div class="info">
                      Total Items
                      <span><a href="items.php"><? echo (countItem('itemID', 'items')); ?></a></span>
                  </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="stat st-comments">
                  <i class= "fas fa-comments"></i>
                  <div class="info">
                      Total Comment
                      <span><a href="comments.php"><? echo (countItem('commentID', 'comments')); ?></a></span>
                  </div>
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
                      <i class="card-title fa fa-users"></i> Latest <? echo $numUsers; ?> Registerd Users
                      <span class="toggle-info float-right">
                          <i class="fa fa-plus"></i>
                      </span>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled latest-users">
                            <?php

                                foreach ($latestsUsers as $user) {

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
                      <i class="card-title fa fa-tag"></i> Latest <? echo $numItems;?> Items
                      <span class="toggle-info float-right">
                          <i class="fa fa-plus"></i>
                      </span>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled latest-users">
                            <?php

                                foreach ($latestsitems as $item) {

                                    echo '<li>' . $item['name'] ;
                                    echo    '<a href="items.php?do=edit&itemID='. $item['itemID'].'"><span class="btn btn-success float-right">';
                                    echo        '<i class="fa fa-edit"></i>Edit';
                                    echo    '</span></a>';
                                    echo '</li>';
                                }
                            ?>
                        </ul>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Start Latset Comment -->
              <div class="row">
                <div class="col-sm-6">
                  <div class="card">
                    <div class="card-heading">
                      <i class="card-title fa fa-comments"></i> Latest <? echo $numComments; ?> Comments
                      <span class="toggle-info float-right">
                          <i class="fa fa-plus"></i>
                      </span>
                    </div>
                    <div class="card-body">
                        <?
                        //Select All Users From Databse Except Admins

                        $stmt = $con->prepare("SELECT
                                                  comments.* , Users.Username AS user_name
                                               FROM
                                                  comments
                                               INNER JOIN
                                                  Users
                                               ON
                                                  Users.userID = comments.userID
                                               ORDER BY
                                                     commentID desc
                                               LIMIT
                                                  $numComments");
                        $stmt->execute();
                        $comments = $stmt->fetchAll();

                        foreach ($comments as $comment) {

                            echo "<div class='comment-box'>";
                                echo "<span class='member-n' >";
                                    echo "<a href='comments.php'>" . $comment['user_name'] . "</a> ";
                                echo "</span>";
                                echo "<p class='member-c' >" . $comment['comment'] . "</p>";
                            echo "</div>";
                        }
                         ?>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Latset Comment -->
            </div>
        </div>
        <?
    }else {

        header('location: index.php');
        exit();
    }

    ob_end_flush();
?>
