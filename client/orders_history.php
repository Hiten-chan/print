<?php require_once("../includes/connection.php"); ?>

<?php
$state1 = 'links active';
$state2 = 'links';
$state3 = 'links';
$state4 = 'links';
include("menu_client.php");

$username = $_SESSION['session_username'];
$user_id = '';
$user_id = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE username = '" . $username . "'"))['user_id'];
$dbname = $link;
$tablename = 'orders';
?>


<?php include("../includes/header_account.php"); ?>
<div id="ohistory" class="content" style="display: block">
    <div class="container_order_history">
        <center>
            <div id="settings">
                <h1>Ваша история заказов</h1>

                <?php include("client_show_table.php");
                if (isset($_POST['cancel'])) {

                    $id_order = htmlspecialchars($_POST['idorder']);
                    $result = mysqli_query($link, "UPDATE orders SET `status` = 'Отменен' WHERE order_id = '" . $id_order . "'");

                    if ($result != 0) {
                        include("client_show_table.php");
                    } else {
                        printf("Errormessage: %s\n", mysqli_error($link));
                    }

                }
                ?>
                <?php echo $structure; ?>
            </div>
        </center>
    </div>
</div>