<?php require_once("../includes/connection.php"); ?>



<?php
$state1 = 'links active';
$state5 = 'links';
$state2 = 'links';
$state3 = 'links';
$state4 = 'links';
include("menu_operator.php");

$dbname = $link;
$tablename = 'orders';
?>

<div id="orders" class="content" style="display: block">
    <div class="container_order_history">
        <center>
            <div id="settings">
                <h1>Работа с заказами</h1>
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


                if (isset($_POST['changetypo'])) {

                    $typo_id = htmlspecialchars($_POST['typo']);
                    $id_order = htmlspecialchars($_POST['idorder']);

                    if ($typo_id != '0') {

                        $result = mysqli_query($link, "UPDATE orders SET `typo_id` = '" . $typo_id . "' WHERE order_id = '" . $id_order . "'");


                        if ($result != 0) {
                            include("operator_show_table.php");
                        } else {
                            printf("Errormessage: %s\n", mysqli_error($link));
                        }
                    }

                }
                ?>

                <?php echo $structure; ?>

                <div id="controls">
                    <div class="perpage" id="perpage">
                        <select id="perpage_select" onchange="sorter.size(this.value)">
                            <option value="5">5</option>
                            <option value="10" selected="selected">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <!--                        <span>Количество записей на странице</span>-->
                    </div>
                    <div id="navigation">
                        <img src="../images/first.png" width="16" height="16" alt="First Page"
                             onclick="sorter.move(-1,true)"/>
                        <img src="../images/previous.png" width="16" height="16" alt="First Page"
                             onclick="sorter.move(-1)"/>
                        <img src="../images/next.png" width="16" height="16" alt="First Page" onclick="sorter.move(1)"/>
                        <img src="../images/last.png" width="16" height="16" alt="Last Page"
                             onclick="sorter.move(1,true)"/>
                    </div>
                    <div id="text">Страница <span id="currentpage"></span> из <span id="pagelimit"></span></div>
                </div>

                <script type="text/javascript" src="../scripts/diff_display.js"></script>
                <script type="text/javascript" src="../scripts/sort_odisplay.js"></script>

            </div>
        </center>
    </div>
</div>




