<?php
session_start();
if(!isset($_SESSION["session_username"])){header("location:../login.php");}
?>

<?php include("../includes/header_account.php"); ?>
<div id="welcome">
    <h2>Добро пожаловать оператор, <span><?php echo $_SESSION['session_username'];?></span>!</h2>
</div>
<?php include("../includes/footer.php"); ?>

<?php
header('Refresh: 1; URL=orders.php');
exit; ?>
