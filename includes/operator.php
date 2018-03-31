<?php

session_start();

if(!isset($_SESSION["session_username"])):
    header("location:login.php");
else:
    ?>

<?php include("header.php"); ?>
<div id="welcome">
    <h2>Добро пожаловать оператор, <span><?php echo $_SESSION['session_username'];?></span>!</h2>
</div>
<?php include("footer.php"); ?>
<?php endif;?>

<?php
header('Refresh: 2; URL=intropage_o.php');
exit; ?>
