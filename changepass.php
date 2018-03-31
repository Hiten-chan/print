<?php require_once("includes/connection.php"); ?>
<?php include("includes/header.php"); ?>

<?php
$username = $_SESSION['session_username'];
$message = '';
$que = '';
$newp = '';

if (isset($_POST["savepass"])) {

    $oldpass = htmlspecialchars($_POST['oldpass']);
    $newpass = htmlspecialchars($_POST['newpass']);

    if (!empty($oldpass) && !empty($newpass)) {

        $que = mysqli_query($link, "SELECT * FROM users WHERE username = '" . $username . "'");
        $numrows = mysqli_num_rows($que);

        if ($numrows != 0) {
            while ($row = mysqli_fetch_assoc($que)) {

                $dbpassword = $row['password'];
            }

            if (password_verify($oldpass, $dbpassword)) {
                $newp = password_hash($newpass, PASSWORD_DEFAULT);

                $sql3 = "UPDATE users SET password = '" . $newp . "' WHERE username = '" . $username . "'";
                $result3 = mysqli_query($link, $sql3);

                if ($result3) {
                    $message = "Пароль успешно изменен!";

                } else {
                    $message = "Ошибка при работе с базой данных";
                }

            } else {
                $message = "Неверный старый пароль!";
            }
        }

    } else {
        $message = "Пароль не может быть пустым!";
    }
}
?>


<!--    action="1.php"-->
<div class="container msettings">
    <center><div id="chpass">
            <h1>Смена пароля</h1>
            <span style="color:red"><?php echo $message; ?></span>
            <form id="chpassform" method="post" name="chpassform">
                <p><label for="old_pass">Старый пароль<br>
                        <input class="input" id="oldpass" name="oldpass" size="20" type="password" value=""></label></p>
                <p><label for="new_pass">Новый пароль<br>
                        <input class="input" id="newpass" name="newpass" size="20" type="password" value=""></label></p>
                <p class="submit"><input class="button" id="savepass" name="savepass" type="submit" value="Сохранить изменения"></p>
            </form>
        </div></center>
</div>
