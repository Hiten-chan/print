<?php

$structure = '';
$res = mysqli_query($dbname, "SHOW COLUMNS FROM $tablename");
$colnames = '';
while ($col = mysqli_fetch_row($res)) {$colnames .= $col[0] . ',';}

$colnames = substr($colnames, 0, -1);

$query = "SELECT * FROM $tablename";
$result = mysqli_query($dbname, $query);

$total_rows = mysqli_num_rows($result);

$colnames = explode(',', $colnames);

$ruscolnames = '№ Заказа,ID клиента,Тип,Бумага,Размер,Кол-во,Дата создания,Срок исполнения,URL,Цена (₽),Типограф,Статус';
$ruscolnames = explode(',', $ruscolnames);


if (!$total_rows) {
    $structure .= "<HTML><BODY><h2>Не создано ни одного заказа</h2></BODY></HTML>\r\n";
    return;
}

$row = mysqli_fetch_row($result);
$total_cols = count($row);

$urlindex = array_search('url', $colnames);
$statusindex = array_search('status', $colnames);
$costindex = array_search('cost', $colnames);
$user_idindex = array_search('user_id', $colnames);
$order_idindex = array_search('order_id', $colnames);
$countindex = array_search('amount', $colnames);
$deadlineindex = array_search('deadline', $colnames);

$dborderid = '';
$dbstatus = '';
$orderid = '';
$width_title = $total_cols + 1;

//Формируем название таблицы
$structure .= "<table id='grid' width='100%' border='2' cellspacing='1' cellpadding='2' align='center' style='table-layout: auto; overflow: scroll'>\r\n";
//$structure .= "<tr><td colspan=$width_title align=center style='font-weight: bold'>Ваши заказы</td></tr>" . "\r\n";


//Формируем шапку таблицы
$structure .="<thead>\r\n<tr>\r\n";

$i = 0;
while ($i < count($ruscolnames)) {

    if ($i == $costindex || $i == $user_idindex || $i == $order_idindex || $i == $countindex){
        $structure .= "<th data-type='number' align='center' style= 'font-size: smaller'>$ruscolnames[$i]</th>\r\n";
    } else {
        $structure .= "<th data-type='string' align='center' style= 'font-size: smaller'>$ruscolnames[$i]</th>\r\n";
    }
    $i++;
}
$structure .= "<th align='center' style= 'font-size: smaller'>Изменить статус</th>\r\n";

$structure .= "</tr>\r\n</thead>\r\n";



$structure .= "<tbody>\r\n<tr>\r\n";
$i = 0;

while ($i < $total_cols) {
    if ($i == $urlindex) {
        $structure .= "<td align='center'><a href=$row[$i]>URL</a></td>\r\n";
    } else if ($i == $statusindex) {
        if ($row[$i] == 'Отменен' || $row[$i] == 'Закрыт') {
            $structure .= "<td align='center' style='color: rgba(255,0,4,0.93); font-weight: bolder'>$row[$i]</td>\r\n";
        } elseif ($row[$i] == 'В обработке' || $row[$i] == 'Подтвержден') {
            $structure .= "<td align='center' style='color: #ffaa45; font-weight: bold'>$row[$i]</td>\r\n";
        } elseif ($row[$i] == 'Исполняется' || $row[$i] == 'Готов к выдаче') {
            $structure .= "<td align='center' style='color: rgba(9,191,26,0.93); font-weight: bolder'>$row[$i]</td>\r\n";
        } else {
            $structure .= "<td align='center'>$row[$i]</td>\r\n";
        }
        $dbstatus = $row[$i];

    } else if ($i == $costindex) {
        $structure .= "<td align='center'>$row[$i]</td>\r\n";
    } else {
        $structure .= "<td align='center'>$row[$i]</td>\r\n";
    }

    if ($i == $dborderid) {
        $orderid = $row[$i];
    }
    $i++;
}
if ($dbstatus == 'В обработке' || $dbstatus == 'Подтвержден') {
    $structure .= "<td align='center'><form method='post'><input type='text' name='idorder' value=$orderid hidden='hidden'><input formaction='orders_history.php' class='button' name='cancel' type='submit' value='Отменить'></form></td>\r\n";
}
$structure .= "<td align='center'></td>\r\n";
$structure .= "</tr>\r\n";


while ($row = mysqli_fetch_row($result)) {
    $i = 0;
    $structure .= "<tr>";

    while ($i < $total_cols) {

        if ($i == $urlindex) {
            $structure .= "<td align='center'><a href=$row[$i]>URL</a></td>\r\n";
        } else if ($i == $statusindex) {
            if ($row[$i] == 'Отменен' || $row[$i] == 'Закрыт') {
                $structure .= "<td align='center' style='color: rgba(255,0,4,0.93); font-weight: bolder'>$row[$i]</td>\r\n";
            } elseif ($row[$i] == 'В обработке' || $row[$i] == 'Подтвержден') {
                $structure .= "<td align='center' style='color: #ffaa45; font-weight: bold'>$row[$i]</td>\r\n";
            } elseif ($row[$i] == 'Исполняется' || $row[$i] == 'Готов к выдаче') {
                $structure .= "<td align='center' style='color: rgba(9,191,26,0.93); font-weight: bolder'>$row[$i]</td>\r\n";
            } else {
                $structure .= "<td align='center'>$row[$i]</td>\r\n";
            }
            $dbstatus = $row[$i];

        } else if ($i == $costindex) {
            $structure .= "<td align='center'>$row[$i]</td>\r\n";
        } else {
            $structure .= "<td align='center'>$row[$i]</td>\r\n";
        }

        if ($i == $dborderid) {
            $orderid = $row[$i];
        }

        $i++;
    }
    if ($dbstatus == 'Отменен' || $dbstatus == 'Закрыт') {
        $structure .= "<td align='center'></td>" . "\r\n";
    } else {
        $structure .= "<td align='center'><form method='post'>\r\n";
        $structure .= "<select class='select' id='status' name='status' style='align-content: center'>\r\n";
        $structure .= "<option value='0'></option>\r\n<option value='В обработке'>В обработке</option>\r\n<option value='Подтвержден'>Подтвержден</option>\r\n";
        $structure .= "<option value='Исполняется'>Исполняется</option>\r\n<option value='Готов к выдаче'>Готов к выдаче</option>\r\n<option value='Закрыт'>Закрыт</option>\r\n";
        $structure .= "<option value='Отменен'>Отменен</option></select>\r\n<input formaction='orders.php' class='button' name='change' type='submit' value='Изменить'>";
        $structure .= "<input type='text' name='idorder' value=$orderid hidden='hidden'></form></td>\r\n";
    }
    $structure .= "</tr>\r\n";
}
$structure .= "</tbody>\r\n";

