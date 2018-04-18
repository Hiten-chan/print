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
<body>
<div id="ohistory" class="content" style="display: block">
    <div class="container_order_history" style="overflow: scroll">
        <center>
            <div id="settings" style="overflow: scroll">
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
                        <img src="../images/first.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1,true)" />
                        <img src="../images/previous.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1)" />
                        <img src="../images/next.gif" width="16" height="16" alt="First Page" onclick="sorter.move(1)" />
                        <img src="../images/last.gif" width="16" height="16" alt="Last Page" onclick="sorter.move(1,true)" />
                    </div>
                    <div id="text">Страница <span id="currentpage"></span> из <span id="pagelimit"></span></div>
                </div>
                <script type="text/javascript" src="../scripts/diff_display.js"></script>
                <script type="text/javascript">
                    var sorter = new TINY.table.sorter("sorter");
                    sorter.head = "head";
                    sorter.asc = "asc";
                    sorter.desc = "desc";
                    sorter.even = "evenrow";
                    sorter.odd = "oddrow";
                    sorter.evensel = "evenselected";
                    sorter.oddsel = "oddselected";
                    sorter.paginate = true;
                    sorter.currentid = "currentpage";
                    sorter.limitid = "pagelimit";
                    sorter.init("table",6);
                </script>


            </div>
        </center>
    </div>
</div>
</body>