<link href="styles/tab_style.css" media="screen" rel="stylesheet">
<script src="scripts/open_tabs.js"></script>

<?php

session_start();

if(!isset($_SESSION["session_username"])):
    header("location:login.php");
else: ?>

<?php endif;?>



<html>
<head>
    <title>Page Title</title>
</head>
<body>
<div id="page">
    <div id="menu">
        <!-- Меню -->
        <div class="tab">
            <button class="links" onclick="openLang(event,'HTML')">История заказов</button>
            <button class="links" onclick="openLang(event,'CSS')">Создать заказ</button>
            <button class="links" onclick="openLang(event,'PHP')">Настройки аккаунта</button>
            <button class="links" onclick="openLang(event,'JS')">Сменить пароль</button>
            <a href="logout.php"><button>Выйти из системы</button></a>
        </div>
    </div>

    <div id="HTML" class="content">
        <h3>Ваша история заказов</h3>

    </div>

    <div id="CSS" class="content">
        <h3>Создать заказ</h3>
        <p>Форма создания заказа</p>
    </div>

    <div id="PHP" class="content">
        <?php include("settings.php");?>
    </div>

    <div id="JS" class="content">
        <h3>Смена пароля</h3>
        <p>Форма смены пароля</p>
    </div>

</div>
</body>
</html>