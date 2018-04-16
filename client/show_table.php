<?php

    $structure = '';
    $res = mysqli_query($dbname, "SHOW COLUMNS FROM $tablename");
    $colnames = '';
    while ($col = mysqli_fetch_row($res)) {
        if ($col[0] != 'user_id') {
            $colnames .= $col[0] . ',';
        }
    }

    $colnames = substr($colnames, 0, -1);

    $query = "SELECT $colnames FROM $tablename WHERE user_id = '" . $user_id . "'";
    $result = mysqli_query($dbname, $query);

    $total_rows = mysqli_num_rows($result);

    $colnames = explode(',', $colnames);

    $ruscolnames = '№ Заказа,Тип,Бумага,Размер,Кол-во,Дата создания,Срок исполнения,URL,Цена,Типограф,Статус';
    $ruscolnames = explode(',', $ruscolnames);


    if (!$total_rows) {
        $structure .= "<HTML><BODY><h2>У вас не создано ни одного заказа</h2></BODY></HTML>" . "\r\n";
        return;
    }

    $row = mysqli_fetch_row($result);
    $total_cols = count($row);

    $urlindex = array_search('url', $colnames);
    $statusindex = array_search('status', $colnames);
    $dborderid = '';
    $dbstatus = '';
    $orderid = '';
    $width_title = $total_cols + 1;


    $structure .= "<table width='100%' border='2' cellspacing='1' cellpadding='0' align='center' style='table-layout: auto; overflow: scroll; font-size: smaller'>" . "\r\n";
    $structure .= "<tr><td colspan=$width_title align=center style='font-weight: bold'>Ваши заказы</td></tr>" . "\r\n";

    $structure .= "<tr>" . "\r\n";
    $i = 0;
    while ($i < count($ruscolnames)) {
        $structure .= "<td>" . $ruscolnames[$i] . "</td>" . "\r\n";
        $i++;
    }
    $structure .= "<td></td>" . "\r\n";
    $structure .= "</tr>" . "\r\n";


    $structure .= "<tr>" . "\r\n";
    $i = 0;
    while ($i < $total_cols) {
        if ($i == $urlindex) {
            $structure .= "<td>" . '<a href=' . $row[$i] . '>URL</a></td>' . "\r\n";
        } else if ($i == $statusindex) {
            $structure .= "<td>" . $row[$i] . "</td>" . "\r\n";
            $dbstatus = $row[$i];
        } else {
            $structure .= "<td>" . $row[$i] . "</td>" . "\r\n";
        }

        if ($i == $dborderid) {
            $orderid = $row[$i];
        }
        $i++;
    }
    if ($dbstatus == 'В обработке' || $dbstatus == 'Подтвержден') {
        $structure .= "<td><form method='post'><input type='text' name='idorder' value=$orderid hidden='hidden'><input formaction='orders_history.php' class='button' name='cancel' type='submit' value='Отменить'></form></td>" . "\r\n";
    }
    $structure .= "<td></td>" . "\r\n";
    $structure .= "</tr>" . "\r\n";


    while ($row = mysqli_fetch_row($result)) {
        $i = 0;
        $structure .= "<tr>";
        while ($i < $total_cols) {
            if ($i == $urlindex) {
                $structure .= "<td>" . '<a href=' . $row[$i] . '>URL</a></td>' . "\r\n";
            } else if ($i == $statusindex) {
                $structure .= "<td>" . $row[$i] . "</td>" . "\r\n";
                $dbstatus = $row[$i];
            } else {
                $structure .= "<td>" . $row[$i] . "</td>" . "\r\n";
            }

            if ($i == $dborderid) {
                $orderid = $row[$i];
            }

            $i++;
        }
        if ($dbstatus == 'В обработке' || $dbstatus == 'Подтвержден') {
            $structure .= "<td><form method='post'><input type='text' name='idorder' value=$orderid hidden='hidden'><input formaction='orders_history.php' class='button' name='cancel' type='submit' value='Отменить'></form></td>" . "\r\n";
        } else {
            $structure .= "<td></td>" . "\r\n";
        }
        $structure .= "</tr>" . "\r\n";
    }

