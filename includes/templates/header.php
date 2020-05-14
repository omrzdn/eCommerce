<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8" />
        <title><?php getTitle() ?></title>
        <link rel="stylesheet" href="<?php echo $cssRoute; ?>bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $cssRoute; ?>all.css">
        <link rel="stylesheet" href="<?php echo $cssRoute; ?>frontend.css">

    </head>
    <body>
        <div class="upper-bar">
            <div class="container">
                <?
                    if (isset($_SESSION['user'])) { ?>

                        <div class="btn-group">
                            <img src="img.png" alt="" class="img-circle">
                            <span class="btn dropdown-toggle" data-toggle="dropdown">
                                <? echo $sessionUser; ?>
                                <span class="caret"></span>
                            </span>
                            <ul class="dropdown-menu">
                                <li><a href="profile.php">My profile</a></li>
                                <li><a href="profile.php">New Item</a></li>
                                <li><a href="profile.php">LogOut</a></li>
                            </ul>
                        </div>

                        <?
                    }else {
                ?>
                <a href="login.php">
                    <span class="upper-form">LogIn/SignUp</span>
                </a>
                <? } ?>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <div class="container">
            <a class="navbar-brand" href="index.php">HomePage</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav navbar-right">
                  <?
                  foreach (getCat() as $cat) {

                      echo "<li class='nav-item'>";
                        echo"<a class='nav-link' href='categories.php?pageID=" . $cat["ID"] . "&pagename=" . str_replace(' ', '-', $cat['Name']) . "'>
                                " . $cat['Name'] . "
                            </a>";
                      echo "</li>";
                  }
                  ?>
              </ul>
            </div>
          </div>
        </nav>
