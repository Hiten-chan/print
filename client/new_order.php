<?php require_once("../includes/connection.php"); ?>
<?php
$state1 = 'links';
$state2 = 'links active';
$state3 = 'links';
$state4 = 'links';
include("menu_client.php");
?>


<?php
$message1 = '' . $message2 = '' . $message3 = '' . $message4 = '' . $message5 = '';
$ptypes = '' . $sizes = '' . $papers = '' . $duedates = '' . $price = '0';


// Данные из таблицы Типов продукции (product_type)
$query1 = mysqli_query($link, "SELECT * FROM prodtypes");
$row1 = mysqli_fetch_assoc($query1);
do {
    $ptypes .= '<option value=' . $row1['type'] . '>' . $row1['title'] . '</option>';
} while ($row1 = mysqli_fetch_array($query1));


// Данные из таблицы Размеров (sizes)
$query2 = mysqli_query($link, "SELECT * FROM sizes");
$row2 = mysqli_fetch_assoc($query2);
do {
    $sizes .= '<option value=' . $row2['size'] . '>' . $row2['title'] . '</option>';
} while ($row2 = mysqli_fetch_array($query2));


// Данные из таблицы Видов бумаги (papers)
$query3 = mysqli_query($link, "SELECT * FROM papers");
$row3 = mysqli_fetch_assoc($query3);
do {
    $papers .= '<option value=' . $row3['paper'] . '>' . $row3['title'] . '</option>';
} while ($row3 = mysqli_fetch_array($query3));


// Данные из таблицы Сроков исполнения (duedates)
$query4 = mysqli_query($link, "SELECT * FROM duedates");
$row4 = mysqli_fetch_assoc($query4);
do {
    $duedates .= '<option value=' . $row4['duedate'] . '>' . $row4['title'] . '</option>';
} while ($row4 = mysqli_fetch_array($query4));


if (isset($_POST["save"])) {
    $type = htmlspecialchars($_POST['type']);

}
?>

<?php
$username = $_SESSION['session_username'];

?>


<?php include("../includes/header_account.php"); ?>
<div id="neworder" class="content" style="display: block">
    <div class="container settings">
        <center>
            <div id="settings">
                <h1>Создание нового заказа</h1>
                <?php echo $message1; ?>
                <?php echo $message2; ?>
                <?php echo $message3; ?>
                <form id="settingsform" method="post" name="settingsform">

                    <p><label>Вид печатной продукции
                            <select class="select" id="ptype" name="ptype">
                                <option>Выберите тип продукции</option>
                                <?php echo $ptypes ?>
                            </select></label></p>

                    <p><label>Формат печати
                            <select class="select" id="psize" name="psize">
                                <option>Выберите формат печати</option>
                                <?php echo $sizes ?>
                            </select></label></p>

                    <p><label>Тип бумаги
                            <select class="select" id="ppaper" name="ppaper">
                                <option>Выберите тип бумаги</option>
                                <?php echo $papers ?>
                            </select></label></p>

                    <p><label>Количество копий
                            <input class="select" id="pcount" name="pcount" type="number" required/></label></p>

                    <p><label>Ориентировочный срок исполнения заказа
                            <select class="select" id="ppaper" name="ppaper">
                                <option>Выберите время исполнения</option>
                                <?php echo $duedates ?>
                            </select></label></p>

                    <table>
                        <tr>
                            <td width="70%" align="left"><p class="submit" style="float: left"><input class="button"
                                                                                                      id="price"
                                                                                                      name="price"
                                                                                                      type="submit"
                                                                                                      value="Рассчитать стоимость">
                            </td>
                            <td width="30%" align="right"><span style="font-weight: bolder; font-size: large; color: darkgreen"><?php echo $price; ?> ₽</span></td>
                        </tr>
                        <tr>
                            <td width="50%" align="left"></td>
                            <td width="50%" align="right"><p class="submit"><input class="button" id="save" name="save"
                                                                                    type="submit"
                                                                                    value="Создать заказ"></p></td>
                        </tr>
                    </table>
                </form>
            </div>
        </center>
    </div>
</div>