<?php

//function showtable($dbname, $tablename, $userid)
//{

    $structure = '';
    $res = mysqli_query($dbname, "SHOW COLUMNS FROM $tablename");
    $colnames = '';
    while ($col = mysqli_fetch_row($res)) {
        if ($col[0] != 'user_id') {
            $colnames .= $col[0] . ', ';
        }
    }

    $colnames = substr($colnames, 0, -2);

    $query = "SELECT $colnames FROM $tablename WHERE user_id = '" . $user_id . "'";
    $result = mysqli_query($dbname, $query);

    $total_rows = mysqli_num_rows($result);

    $colnames = explode(',', $colnames);


    if (!$total_rows) {
        $structure .= "<HTML><BODY><h2>У вас не создано ни одного заказа</h2></BODY></HTML>";
        return;
    }

    $row = mysqli_fetch_row($result);
    $total_cols = count($row);

    $urlindex = array_search(' url', $colnames);
    $statusindex = array_search(' status', $colnames);
    $dborderid = '';
    $dbstatus = '';
    $orderid = '';
    $width_title = $total_cols + 1;


    $structure .= "<table width='100%' border='2' cellspacing='0' cellpadding='0' align='center' style='table-layout: auto'>";
    $structure .= "<tr><td colspan=$width_title align=center>История заказов</td></tr>";

    $structure .= "<tr>";
    $i = 0;
    while ($i < count($colnames)) {
        $structure .= "<td>" . $colnames[$i] . "</td>";
        $i++;
    }
    $structure .= "<td></td>";
    $structure .= "</tr>";


    $structure .= "<tr>";
    $i = 0;
    while ($i < $total_cols) {
        if ($i == $urlindex) {
            $structure .= "<td>" . '<a href=' . $row[$i] . '>URL</a></td>';
        } else if ($i == $statusindex) {
            $structure .= "<td>" . $row[$i] . "</td>";
            $dbstatus = $row[$i];
        } else {
            $structure .= "<td>" . $row[$i] . "</td>";
        }

        if ($i == $dborderid) {
            $orderid = $row[$i];
        }
        $i++;
    }
    if ($dbstatus == 'В обработке') {
        $structure .= "<td><form method='post'><input type='text' name='idorder' value=$orderid hidden='hidden'><input formaction='orders_history.php' class='button' name='cancel' type='submit' value='Отменить'></form></td>";
    }
    $structure .= "</tr>";


    while ($row = mysqli_fetch_row($result)) {
        $i = 0;
        $structure .= "<tr>";
        while ($i < $total_cols) {
            if ($i == $urlindex) {
                $structure .= "<td>" . '<a href=' . $row[$i] . '>URL</a></td>';
            } else if ($i == $statusindex) {
                $structure .= "<td>" . $row[$i] . "</td>";
                $dbstatus = $row[$i];
            } else {
                $structure .= "<td>" . $row[$i] . "</td>";
            }

            if ($i == $dborderid) {
                $orderid = $row[$i];
            }

            $i++;
        }
        if ($dbstatus == 'В обработке' OR $dbstatus == 'Подтвержден') {
            $structure .= "<td><form method='post'><input type='text' name='idorder' value=$orderid hidden='hidden'><input formaction='orders_history.php' class='button' name='cancel' type='submit' value='Отменить'></form></td>";
        } else {
            $structure .= "<td></td>";
        }
        $structure .= "</tr>";
    }
//}



