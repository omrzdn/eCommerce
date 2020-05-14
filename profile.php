<?php
    session_start();

    $pageTitle = 'profile';

    include 'ini.php';

    if (isset($_SESSION['user'])) {

        $getUser = $con->prepare("SELECT * FROM Users WHERE Username = ?");

        $getUser->execute(array($sessionUser));

        $info = $getUser->fetch();
?>

<h1 class="text-center">My Profile</h1>
<div class="information block">
    <div class="container">
        <div class="card">
            <div class="card-default card-heading">My Information</div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li>
                        <span>Name</span> : <? echo $info['Username'] ;?>
                    </li>
                    <li>
                        <span>Fullname</span> : <? echo $info['FullName'] ;?>
                    </li>
                    <li>
                        <span>Email</span> : <? echo $info['Email'] ;?>
                    </li>
                    <li>
                        <span>Date</span> : <? echo $info['Date'] ;?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="my-ads block">
    <div class="container">
        <div class="card ">
            <div class="card-default card-heading">My Ads</div>
            <div class="card-body">
                    <?
                    if (!empty(getItems('memberID',$info['userID']))) {

                        echo "<div class='row'>";
                            foreach (getItems('memberID',$info['userID']) as $item) {
                                echo '<div class="col-sm-6 col-md-3">';
                                    echo '<div class="img-thumbnail item-box">';
                                        echo '<span class="price-tag">' . $item['price'] . '</span>';
                                        echo '<img class="img-fluid" src="img.png" alt="" />';
                                        echo '<div class="caption">';
                                                echo '<h3>' . $item['name'] . '</h3>';
                                                echo '<p>' . $item['description'] . '</p>';
                                        echo '</div>';
                                    echo '</div>';
                                echo "</div>";
                            }
                        echo "</div>";
                }else {

                        echo "There\'s No Ads to Show, Create New Ad <a href='newad.php'>New Add</a>";
                    }
                    ?>
            </div>
        </div>
    </div>
</div>

<div class="my-comments block">
    <div class="container">
        <div class="card ">
            <div class="card-default card-heading">lastest Comments</div>
            <div class="card-body">
                <?
                $stmt = $con->prepare("SELECT comment FROM comments WHERE userID = ?");
                $stmt->execute(array($info['userID']));

                $comments = $stmt->fetchAll();

                if (!empty($comments)) {

                    foreach ($comments as $comment) {

                        echo "<p>" . $comment['comment'] . "</p>" ;
                    }
                }else {

                    echo "There is no Comments to Show";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?
    }else {

        header('location: login.php');
    }
    include $tplRoute . "footer.php";
?>
