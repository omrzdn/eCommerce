<?php

global $con;
$stmt = $con->prepare("SELECT FullName FROM Users WHERE userID = :userid");
$stmt->execute([

    ':userid' => $_SESSION['ID']
]);

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">HOME</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="categories.php">CATEGORIES</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="items.php">ITEMS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="members.php">MEMBERS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comments.php">COMMENTS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Statistics</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Logs</a>
        </li>
      </ul>
      <ul class="navbar-nav dropdownprofile">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?
          echo $stmt->fetchColumn();
          ?>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="../index.php">Vists Shop</a>
            <a class="dropdown-item" href="members.php?do=edit&userID=<?php echo $_SESSION['ID'];?>">Edit Profile</a>
            <a class="dropdown-item" href="#">Settings</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php require_once $tplRoute . "footer.php"; ?>
