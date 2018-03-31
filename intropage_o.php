<link href="styles/tab_style.css" media="screen" rel="stylesheet">
<script src="scripts/open_tabs.js"></script>

<?php

session_start();

if (!isset($_SESSION["session_username"])):
    header("location:login.php");
else: ?>

<?php endif; ?>


<html>
<head>
    <title>Page Title</title>
</head>
<body>
<div id="page">
    <div id="menu">
        <!-- Меню -->
        <div class="tab">
            <button class="links" onclick="openLang(event,'HTML')">Заказы</button>
            <button class="links" onclick="openLang(event,'CSS')">Нотификации</button>
            <button class="links" onclick="openLang(event,'JS')">Настройки аккаунта</button>
            <a href="logout.php"><button>Выйти из системы</button></a>
        </div>
    </div>

    <div id="HTML" class="content">
        <h3>Заказы</h3>
        <p>Таблица с заказами пользователей</p>
    </div>

    <div id="CSS" class="content">
        <h3>Нотификации</h3>
        <p>Таблица с Нотификациями</p>
    </div>

    <div id="JS" class="content">
        <?php include("settings.php"); ?>
    </div>

</div>
</body>
</html>