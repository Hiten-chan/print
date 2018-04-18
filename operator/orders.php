<?php require_once("../includes/connection.php"); ?>



<?php
$state1 = 'links active';
$state2 = 'links';
$state3 = 'links';
$state4 = 'links';
include("menu_operator.php");

$dbname = $link;
$tablename = 'orders';
?>

<style>
    th {
        cursor: pointer;
    }

    th:hover {
        background: #ff891c;
    }
</style>

<div id="orders" class="content" style="display: block">
    <div class="container_order_history">
        <center>
            <div id="settings">
                <h1>Таблица заказов</h1>
                <?php include("operator_show_table.php");
                if (isset($_POST['change'])) {

                    $status = htmlspecialchars($_POST['status']);
                    $id_order = htmlspecialchars($_POST['idorder']);

                    if ($status != '0') {

                        $result = mysqli_query($link, "UPDATE orders SET `status` = '" . $status . "' WHERE order_id = '" . $id_order . "'");


                        if ($result != 0) {
                            include("operator_show_table.php");
                        } else {
                            printf("Errormessage: %s\n", mysqli_error($link));
                        }
                    }

                }
                ?>
                <?php echo $structure; ?>
                <script src="../scripts/sort_table.js"></script>
            </div>
        </center>
    </div>
</div>




