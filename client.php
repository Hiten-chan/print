<?php

session_start();

if(!isset($_SESSION["session_username"])):
    header("location:login.php");
else:
    ?>

<?php include("includes/header.php"); ?>
<div id="welcome">
    <h2>Добро пожаловать, <span><?php echo $_SESSION['session_username'];?></span>!</h2>
</div>
<?php include("includes/footer.php"); ?>
<?php endif; ?>

<?php
header('Refresh: 1; URL=intropage_c.php');
exit; ?>