<?php 
    session_start();

    $pageTitle = 'Login Page';
    $noNavbar = '';

    if (isset($_SESSION['username'])) {
        
        header('location: dashboard.php'); //redircet to dashborad 
    }

    include 'ini.php';

    // Chech if user Coming from HTTP Post Request

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedpass = sha1($password);
        
        //chech if user exist in Database
        
        $stmt = $con -> prepare("SELECT userID, Username, Password From Users WHERE Username = ?  AND password = ? AND GroupID = 1");
        $stmt ->execute(array($username, $hashedpass));
        $row = $stmt -> fetch();
        $count = $stmt ->rowCount();
        
        // if Count > 0 This Mean the Daabase Contain Record About this Username 
        
        if ($count > 0 ) {
            
            $_SESSION['username'] = $username; //Register Session Name 
            $_SESSION['ID'] = $row['userID']; //Register Session ID 
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

