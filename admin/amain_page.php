<?php require_once("../includes/connection.php"); ?>
<?php
$state1 = 'links active';
$state2 = 'links';
$state3 = 'links';

include("menu_admin.php"); ?>

<?php

$message = '';
$message1 = '';


if (isset($_POST["save"])) {
    $username = htmlspecialchars($_POST['login']);
    $tag = htmlspecialchars($_POST['tag']);

    if (mysqli_num_rows(mysqli_query($link, "SELECT * FROM users WHERE username = '" . $username . "'")) != 0) {
        if ($tag == 'a' || $tag == 'c' || $tag == 'o') {
            $result = mysqli_query($link, "UPDATE users SET tag = '" . $tag . "' WHERE username = '" . $username . "'");
            if ($result != 0) {
                $message1 = '<span class = "good">Уровень доступа пользователя<br> ' . $username . ' изменен</span></br>';
            } else {
                $message1 = '<span class = "bad">Ошибка при работе с базой данных ¯\_(ツ)_/¯</span></br>';
                printf("Errormessage: %s\n", mysqli_error($link));
            }
        } else {
            $message1 = '<span class = "bad">Указан несуществующий уровень доступа ¯\_(ツ)_/¯</span></br>';
        }
    } else {
        $message1 = '<span class = "bad">Пользователь с таким логином не найден ¯\_(ツ)_/¯</span></br>';
    }
}

if (isset($_POST["find_admin"])) {
    $query_admin = mysqli_query($link, "SELECT * FROM users WHERE tag = 'a'");
    $row = mysqli_fetch_array($query_admin);
    do {
        $message .= $row['username'] . "\r\n";
    } while ($row = mysqli_fetch_array($query_admin));
}

if (isset($_POST["find_oper"])) {
    $query_oper = mysqli_query($link, "SELECT * FROM users WHERE tag = 'o'");
    $row = mysqli_fetch_array($query_oper);
    do {
        $message .= $row['username'] . "\r\n";
    } while ($row = mysqli_fetch_array($query_oper));
}
?>



<?php include("../includes/header_account.php"); ?>
<div id="csetting" class="content" style="display: block">
    <div class="container settings">
        <center>
            <div id="settings">
                <h1>Администрирование</h1>
                <form id="settingsform" method="post" name="settingsform">
                    <h2><label>Изменение уровня доступа пользователей</h2>
                    <?php echo $message1; ?>
                    <table style="table-layout: fixed">
                        <tr>
                            <td width="50%" align="center"><label>Логин</label></td>
                            <td width="50%" align="center"><label>Уровень доступа</label></td>
                        </tr>
                        <tr>
                            <td align="center"><input class="input" id="ctag" name="login" type="text"
                                                      value="<?php //echo $dbphone; ?>"></td>
                            <td align="center"><input class="input" id="ctag" name="tag" type="text"
                                                      value="<?php //echo $dbphone; ?>"></td>
                        </tr>
                        <tr>
                            <td><label style="float: left">Уровни доступа:</label>
                                <label style="float: left"><b>o</b> - Оператор</label><br>
                                <label style="float: left"><b>a</b> - Администратор</label><br>
                                <label style="float: left"><b>c</b> - Клиент сервиса</label><br></td>
                            <td><p class="submit"><input class="button" id="save" name="save" type="submit"
                                                         value=" Сохранить изменения "></p></td>
                        </tr>
                    </table>

                    <h2><label>___________________________________________________</h2>
                    <table>
                        <tr>
                            <td width="50%"><p class="submit"><input class="button" id="save"
                                                                     name="find_oper" type="submit"
                                                                     style="white-space: pre-line"
                                                                     value="Вывести список операторов"></p></td>
                            <td width="50%"><p class="submit"><input class="button" id="save" name="find_admin"
                                                                     type="submit"
                                                                     style="white-space: pre-line"
                                                                     value="Вывести список администраров"></p></td>
                        </tr>
                    </table>
                    <textarea  rows="6" style="resize: vertical; width: 100%; min-height: 10%"
                              readonly><?php echo $message; ?></textarea>
                </form>
            </div>
        </center>
    </div>
</div>
