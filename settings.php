<?php require_once("/Users/macintosh/web_projects/print/includes/connection.php"); ?>
<?php include("/Users/macintosh/web_projects/print/includes/header.php"); ?>

<?php

$username = $_SESSION['session_username'];
$message = '';
$message2 = '';
$message3 = '';
$query = '';

$q = mysqli_query($link, "SELECT * FROM users WHERE username = '" . $username . "'");
$n = mysqli_num_rows($q);

while ($row = mysqli_fetch_assoc($q)) {

$dbusername = $row['username'];
$dbfullname = $row['fullname'];
$dbphone = $row['phone'];
$dbemail = $row['email'];}


/*= КАКАЯ-ТО ТУПАЯ ЛОГИКА, НУЖНО ПЕРЕДЕЛАТЬ
	--------------------------------------------------------*/
if (isset($_POST["save"])) {

    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);

    if (!empty($email)) {

        $query = mysqli_query($link, "SELECT * FROM users WHERE email = '" . $email . "'");
        $numrows2 = mysqli_num_rows($query);

        if ($numrows2 != 0) {
            $message = "Такой email уже зарегистрирован в системе!";

        } else {
            $sql1 = "UPDATE users SET email = '" . $email . "' WHERE username = '" . $username . "'";
            $result1 = mysqli_query($link, $sql1);

            if ($result1) {
            $message = 'Новые данные сохранены';}
        }
    } else {
        $message = "Поле E-mail не может быть пустым!";
    }

    if (!empty($fullname)){
        $sql2 = "UPDATE users SET fullname = '" . $fullname . "' WHERE username = '" . $username . "'";
        $result2 = mysqli_query($link, $sql2);

        if ($result2) {
            $message = "Новые данные сохранены";

        } else {

            $message = "Ошибка при работе с базой данных";
        }}



    if (!empty($phone)){
        $sql3 = "UPDATE users SET phone = '" . $phone . "' WHERE username = '" . $username . "'";
        $result3 = mysqli_query($link, $sql3);

        if ($result3) {
            $message = "Новые данные сохранены";

        } else {

            $message = "Ошибка при работе с базой данных";
    }}
}
?>

<!--    action="1.php"-->
    <div class="container msettings">
        <center><div id="settings">
            <h1>Настройки</h1>
            <span style="color:red"><?php echo $message; ?></span>
            <span style="color:red"><?php echo $message2; ?></span>
            <span style="color:red"><?php echo $message3; ?></span>
            <form id="settingsform" method="post" name="settingsform">
                <p><label for="user_pass">Логин для входа:</p>
                <p><big><big><span><?php echo $_SESSION['session_username'];?></span></big></big></p>
                <p><label for="user_login">Полное имя<br>
                        <input class="input" id="fullname" name="fullname" size="32" type="text" value="<?php echo $dbfullname; ?>"></label></p>
                <p><label for="user_pass">Телефон<br>
                        <input class="input" id="phone" name="phone" placeholder="8**********" size="32" type="text" value="<?php echo $dbphone; ?>"></label></p>
                <p><label for="user_pass">E-mail<br>
                        <input class="input" id="email" name="email" size="32" type="email" value='<?php echo $dbemail;?>'></label></p>
                <p class="submit"><input class="button" id="save" name="save" type="submit" value="Сохранить изменения"></p>
            </form>
        </div></center>
    </div>

