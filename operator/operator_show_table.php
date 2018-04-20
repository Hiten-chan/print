<?php

$structure = '';
$res = mysqli_query($dbname, "SHOW COLUMNS FROM $tablename");
$colnames = '';
while ($col = mysqli_fetch_row($res)) {
    $colnames .= $col[0] . ',';
}

$colnames = substr($colnames, 0, -1);

$query = "SELECT * FROM $tablename WHERE status NOT LIKE 'Отменен' AND status NOT LIKE 'Закрыт'";
$result = mysqli_query($dbname, $query);

$total_rows = mysqli_num_rows($result);

$colnames = explode(',', $colnames);

$ruscolnames = '№ Заказа,ID клиента,Тип,Бумага,Формат,Кол-во,Дата<br>создания,Срок исполнения,URL,Цена (₽),ID Типографа,Статус';
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
$typoindex = array_search('typo_id', $colnames);

$dborderid = '';
$dbstatus = '';
$orderid = '';
$typographers = '<option value=""></option>\r\n';
$width_title = $total_cols + 1;


// Данные из таблицы Типографы
$query1 = mysqli_query($link, "SELECT * FROM typographers");
$row1 = mysqli_fetch_assoc($query1);
do {
    $typographers .= '<option value=' . $row1['typo_id'] . '>' . $row1['typo_id'] . '</option>' . "\r\n";
} while ($row1 = mysqli_fetch_array($query1));


//Формируем название таблицы
$structure .= "<table id='table' class='sortable' width='100%' border='1' cellspacing='1' cellpadding='1' align='center' style='table-layout: auto; overflow: scroll'>\r\n";
//$structure .= "<tr><td colspan=$width_title align=center style='font-weight: bold'>Ваши заказы</td></tr>" . "\r\n";


//Формируем шапку таблицы
$structure .= "<thead style='font-weight: 600'>\r\n<tr>\r\n";

$i = 0;
while ($i < count($ruscolnames)) {

    if ($i == $costindex || $i == $user_idindex || $i == $order_idindex || $i == $countindex) {
        $structure .= "<th data-type='number' align='center' style= 'font-size: smaller'>$ruscolnames[$i]</th>\r\n";
    } else {
        $structure .= "<th data-type='string' align='center' style= 'font-size: smaller'>$ruscolnames[$i]</th>\r\n";
    }
    $i++;
}
$structure .= "<th class='nosort' align='center' style= 'font-size: smaller'>Изменить статус</th>\r\n";

$structure .= "</tr>\r\n</thead>\r\n";


$structure .= "<tbody>\r\n<tr>\r\n";
$i = 0;

while ($i < $total_cols) {
    if ($i == $urlindex) {
        $structure .= "<td align='center'><a href=$row[$i]>URL</a></td>\r\n";
    } else if ($i == $statusindex) {
        if ($row[$i] == 'В обработке') {
            $structure .= "<td align='center' style='color: #ffaa45; font-weight: bold'><span hidden='hidden'>1</span>$row[$i]</td>\r\n";
        } elseif ($row[$i] == 'Подтвержден') {
            $structure .= "<td align='center' style='color: #ffaa45; font-weight: bold'><span hidden='hidden'>2</span>$row[$i]</td>\r\n";
        } elseif ($row[$i] == 'Исполняется') {
            $structure .= "<td align='center' style='color: rgba(9,191,26,0.93); font-weight: bolder'><span hidden='hidden'>3</span>$row[$i]</td>\r\n";
        } elseif ($row[$i] == 'Готов к выдаче') {
            $structure .= "<td align='center' style='color: rgba(9,191,26,0.93); font-weight: bolder'><span hidden='hidden'>4</span>$row[$i]</td>\r\n";
        } elseif ($row[$i] == 'Отменен') {
            $structure .= "<td align='center' style='color: rgba(255,0,4,0.93); font-weight: bolder'><span hidden='hidden'>6</span>$row[$i]</td>\r\n";
        } elseif ($row[$i] == 'Закрыт') {
            $structure .= "<td align='center' style='color: rgba(255,0,4,0.93); font-weight: bolder'><span hidden='hidden'>5</span>$row[$i]</td>\r\n";
        } else {
            $structure .= "<td align='center'>$row[$i]</td>\r\n";
        }
        $dbstatus = $row[$i];

    } else if ($i == $costindex) {
        $structure .= "<td align='center'>$row[$i]</td>\r\n";

    } else if ($i == $typoindex) {

        $typos = str_replace('<option value=' . $row[$i] . '>' . $row[$i] . '</option>', '<option value=' . $row[$i] . ' selected>' . $row[$i] . '</option>', $typographers);
        $structure .= "<td align='center'><form method='post'>\r\n";
        $structure .= "<select class='select' id='typo' name='typo' style='align-content: center; padding: 0 0 0 5%; -webkit-appearance: none; -moz-appearance: none'>\r\n";
        $structure .= "$typos</select>\r\n<input formaction='orders.php' class='button' name='changetypo' type='submit' value='Назначить'>";
        $structure .= "<input type='text' name='idorder' value=$orderid hidden='hidden'></form></td>\r\n";

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
    $structure .= "<option value='0'>Выберите</option>\r\n<option value='В обработке'>В обработке</option>\r\n<option value='Подтвержден'>Подтвержден</option>\r\n";
    $structure .= "<option value='Исполняется'>Исполняется</option>\r\n<option value='Готов к выдаче'>Готов к выдаче</option>\r\n<option value='Закрыт'>Закрыт</option>\r\n";
    $structure .= "<option value='Отменен'>Отменен</option></select>\r\n<input formaction='orders.php' class='button' name='change' type='submit' value='Изменить'>";
    $structure .= "<input type='text' name='idorder' value=$orderid hidden='hidden'></form></td>\r\n";
}
$structure .= "</tr>\r\n";


while ($row = mysqli_fetch_row($result)) {
    $i = 0;
    $structure .= "<tr>";

    while ($i < $total_cols) {

        if ($i == $urlindex) {
            $structure .= "<td align='center'><a href=$row[$i]>URL</a></td>\r\n";

        } else if ($i == $statusindex) {

            if ($row[$i] == 'В обработке') {
                $structure .= "<td align='center' style='color: #ffaa45; font-weight: bold'><span hidden='hidden'>1</span>$row[$i]</td>\r\n";
            } elseif ($row[$i] == 'Подтвержден') {
                $structure .= "<td align='center' style='color: #ffaa45; font-weight: bold'><span hidden='hidden'>2</span>$row[$i]</td>\r\n";
            } elseif ($row[$i] == 'Исполняется') {
                $structure .= "<td align='center' style='color: rgba(9,191,26,0.93); font-weight: bolder'><span hidden='hidden'>3</span>$row[$i]</td>\r\n";
            } elseif ($row[$i] == 'Готов к выдаче') {
                $structure .= "<td align='center' style='color: rgba(9,191,26,0.93); font-weight: bolder'><span hidden='hidden'>4</span>$row[$i]</td>\r\n";
            } elseif ($row[$i] == 'Отменен') {
                $structure .= "<td align='center' style='color: rgba(255,0,4,0.93); font-weight: bolder'><span hidden='hidden'>6</span>$row[$i]</td>\r\n";
            } elseif ($row[$i] == 'Закрыт') {
                $structure .= "<td align='center' style='color: rgba(255,0,4,0.93); font-weight: bolder'><span hidden='hidden'>5</span>$row[$i]</td>\r\n";
            } else {
                $structure .= "<td align='center'>$row[$i]</td>\r\n";
            }
            $dbstatus = $row[$i];

        } else if ($i == $costindex) {
            $structure .= "<td align='center'>$row[$i]</td>\r\n";

        } else if ($i == $typoindex) {

            $typos = str_replace('<option value=' . $row[$i] . '>' . $row[$i] . '</option>', '<option value=' . $row[$i] . ' selected>' . $row[$i] . '</option>', $typographers);
            $structure .= "<td align='center'><form method='post'>\r\n";
            $structure .= "<select class='select' id='typo' name='typo' style='align-content: center; padding: 0 0 0 5%; -webkit-appearance: none; -moz-appearance: none'>\r\n";
            $structure .= "$typos</select>\r\n<input formaction='orders.php' class='button' name='changetypo' type='submit' value='Назначить'>";
            $structure .= "<input type='text' name='idorder' value=$orderid hidden='hidden'></form></td>\r\n";

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
        $structure .= "<option value='0' style='font-size: 20%'>Выберите</option>\r\n<option value='В обработке'>В обработке</option>\r\n<option value='Подтвержден'>Подтвержден</option>\r\n";
        $structure .= "<option value='Исполняется'>Исполняется</option>\r\n<option value='Готов к выдаче'>Готов к выдаче</option>\r\n<option value='Закрыт'>Закрыт</option>\r\n";
        $structure .= "<option value='Отменен'>Отменен</option></select>\r\n<input formaction='orders.php' class='button' name='change' type='submit' value='Изменить'>";
        $structure .= "<input type='text' name='idorder' value=$orderid hidden='hidden'></form>\r\n";
    }
    $structure .= "</tr>\r\n";
}
$structure .= "</tbody>\r\n";

