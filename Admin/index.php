<?php
    session_start();

    $pageTitle = 'Login Page';
    $noNavbar = '';

    if (isset($_SESSION['username'])) {

        header('location: dashboard.php'); //redircet to dashborad
    }

    include 'ini.php';

    // Chech if user Coming from HTTP Post Request

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedpass = sha1($password);
        //chech if user exist in Database

        $stmt = $con -> prepare("SELECT userID, Username, Password,FullName From Users WHERE Username = :username  AND password = :password AND GroupID = 1");
        $stmt ->execute([

          ':username' => $username,
          ':password' => $hashedpass

        ]);
        $row = $stmt-> fetch();
        $count = $stmt->rowCount();
        // if Count > 0 This Mean the Database Contain Record About this Username

        if ($count > 0 ) {

            echo "welcome" . $username;
            $_SESSION['username'] = $username; //Register Session Name
            $_SESSION['ID']       = $row['userID']; //Register Session ID
            $_SESSION['fullname'] = $row['FullName']; //Register Session Fullname
            header('location: dashboard.php'); //redircet to dashborad
            exit();
        }

    }
?>

    <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        <h4 class="text-center">Admin Login</h4>
        <input
               class="form-control"
               type="text"
               name="user"
               placeholder="Username"
               autocomplete"off">

        <input
               class="form-control"
               type="password"
               name="pass"
               placeholder="password"
               autocomplete"new-password">

        <input
               class="btn btn-block btn-primary"
               type="submit"
               value="login">
    </form>


<?php include $tplRoute . "footer.php"; ?>
