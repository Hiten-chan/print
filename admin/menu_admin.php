<link href="../styles/tab_style.css" media="screen" rel="stylesheet">

<?php
session_start();
if (!isset($_SESSION["session_username"])) {
    header("location:../login.php");
} elseif (mysqli_fetch_assoc(mysqli_query($link, "SELECT tag FROM users WHERE username = '" . $_SESSION["session_username"] . "'"))['tag'] != 'a') {
    header("location:../login.php");
} ?>

<?php include("../includes/header_account.php"); ?>
<div id="menu">
    <!-- Меню -->
    <div class="tab">
        <button class="<?php echo $state1 ?>" onclick="location.href='amain_page.php'">Администрирование</button>
        <button class="<?php echo $state4 ?>" onclick="location.href='add_typos.php'">Типографы</button>
        <button class="<?php echo $state2 ?>" onclick="location.href='asettings.php'">Настройки аккаунта</button>
        <button class="<?php echo $state3 ?>" onclick="location.href='achangepass.php'">Сменить пароль</button>
        <a href="../logout.php">
            <button>Выйти из системы</button>
        </a>
    </div>
</div>
