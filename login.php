<?php
    session_start();
    $pageTitle = 'Login Page';

    if (isset($_SESSION['user'])) {

        header('location: index.php');
    }

    include 'ini.php';

    //Check if user Coming From HTTP post requset

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['login'])) {

            $user       = $_POST['username'];
            $pass       = $_POST['password'];
            $hashedPass = sha1($pass);

            //Check If the User Exist In Database

            $stmt = $con->prepare("SELECT Username, Password FROM users WHERE Username = ? AND Password = ?");
            $stmt->execute(array($user, $hashedPass));
            $count = $stmt->rowCount();

            //If Count bigger than zero that main Database contain record about this username

            if ($count > 0) {

                $_SESSION['user'] = $user;

                header('location: index.php');

                exit();
            }
        }else {

            $user       = $_POST['username'];
            $pass       = $_POST['password'];
            $email      = $_POST['email'];
            $hashedPass = sha1($pass);

            $check = checkItem("Username", "users", $user);

            if ($check == 1) {
                echo "Sorry, This user is exists";
            }else {

                $stmt = $con->prepare("INSERT INTO Users(Username, Password, Email, FullName, RegStatus, Date )
                                        VALUES(:user, :pass, :email, :fn, 0, now())");
                $stmt->execute([
                    ':user'  => $user,
                    ':pass'  => $hashedPass,
                    ':email' => $email,
                    ':fn'    => $user
                ]);

                $successMsg = "Congrats You are now Registred";
            }

        }
    }
?>

<div class="container login-page">
    <h1 class="text-center">
        <span class="selected" data-class="login">Login</span> | <span data-class="signup" >Signup</span>
    </h1>

    <!-- Start Login Form -->
    <form class="login" action="<? echo $_SERVER['PHP_SELF'];?>" method="POST">
        <!--  Start Username Field -->
        <input
            type="text"
            name="username"
            class="form-control"
            autocomplete="off"
            placeholder="Type your username">
        <!--  End Username Field -->

        <!--  Start Password Field -->
        <input
            type="password"
            name="password"
            class="form-control"
            autocomplete="new-password"
            placeholder="Type your password">
        <!-- End Password Field -->

        <!--  Start Submit Field -->
        <input class="submit btn btn-primary" type="submit" name="login" value="Login">
        <!--  End Submit Field -->
    </form>
    <!-- End Login Form -->

    <form class="signup" action="<? echo $_SERVER['PHP_SELF'];?>" method="POST">

        <!--  Start Username Field -->
        <input
            type="text"
            name="username"
            class="form-control"
            autocomplete="off"
            placeholder="Type your username">
        <!--  End Username Field -->

        <!--  Start Password Field -->
        <input
            type="password"
            name="password"
            class="form-control"
            autocomplete="new-password"
            placeholder="Type a Complex password">
        <!-- End Password Field -->

        <!--  Start Password Field -->
        <input
            type="password"
            name="password2"
            class="form-control"
            autocomplete="new-password"
            placeholder="Type a password again">
        <!-- End Password Field -->

        <!--  Start Password Field -->
        <input
            type="email"
            name="email"
            class="form-control"
            placeholder="Type a Valid Email">
        <!-- End Password Field -->

        <!--  Start Submit Field -->
        <input class="submit btn btn-primary" type="submit" name="button" value="Signup">
        <!--  End Submit Field -->
    </form>

    <div class="the-errors text-center">
            <?php
            if (isset($successMsg)) {

                echo "<div class='msg success'>" . $successMsg . "</div>";
            }
            ?>
    </div>
</div>

<? include $tplRoute . "footer.php"; ?>
