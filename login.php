<?php session_start(); ?>
<?php require_once("includes/connection.php"); ?>
<?php include("includes/header.php"); ?>
<?php

if (isset($_SESSION["session_username"])) {

    $username = '';
    $_SESSION['session_username'] = $username;
    $q_base = mysqli_query($link, "SELECT * FROM users WHERE username = '" . $username . "'");
    $tag = mysqli_fetch_assoc($q_base)['tag'];

    if ($tag == 'c') {
        header("Location: intropage_c.php");
    } elseif ($tag == 'o') {
        header("Location: intropage_o.php");
    }

}

$message = '';
$dbusername = '';
$dbpassword = '';


if (isset($_POST["login"])) {

    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {

        $query = mysqli_query($link, "SELECT * FROM users WHERE username = '" . $username . "'");
        $numrows = mysqli_num_rows($query);

        if ($numrows != 0) {
            while ($row = mysqli_fetch_assoc($query)) {

                $dbusername = $row['username'];
                $dbpassword = $row['password'];

            }
            if ($username == $dbusername && password_verify($password, $dbpassword)) {

                $_SESSION['session_username'] = $username;
                $q_base = mysqli_query($link, "SELECT * FROM users WHERE username = '" . $username . "'");
                $tag = mysqli_fetch_assoc($q_base)['tag'];

                if ($tag == 'c') {
                    header("Location: intropage_c.php");
                    exit();
                } else if ($tag == 'o') {
                    header("Location: intropage_o.php");
                    exit();
                }


            }
        } else {
            $message = "Неверное имя пользователя или пароль!";

        }
    } else {
        $message = "Все поля обязательны для заполнения!";
    }
}
?>


    <body>
    <div class="container mlogin">
        <div id="login">
            <h1>Вход</h1>
            <span style="color:red"><?php echo $message; ?></span>
            <form action="" id="loginform" method="post" name="loginform">
                <p><label for="user_login">Имя пользователя<br>
                        <input class="input" id="username" name="username" size="20"
                               type="text" value=""></label></p>
                <p><label for="user_pass">Пароль<br>
                        <input class="input" id="password" name="password" size="20"
                               type="password" value=""></label></p>
                <p class="submit"><input class="button" name="login" type="submit" value="Вход"></p>
                <p class="regtext">Еще не зарегистрированы? <br><a href="register.php">Регистрация!</a></p>
            </form>
        </div>
    </div>
    </body>
<?php include("includes/footer.php"); ?>