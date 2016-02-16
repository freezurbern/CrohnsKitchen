<?php
/**
 * Created by PhpStorm.
 * User: zachery
 * Date: 2/13/2016
 * Time: 7:26 AM
 */

function genDataTable($name, $dataArray, $headers) {
    $output = "";
    if (!is_array($dataArray)) {
        $output .= "Error. No data array given";
        return $output;
    }
    //print_r($dataArray);

    // print JavaScript for DataTables
$output .= <<<EOT
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {
            $('#$name').DataTable();
        } );
    </script>

<table id="$name" class="display">
    <thead>
    <tr>
EOT;

$heads = array_keys($dataArray[0]);
$length = count($heads);
    for ($i = 0; $i < $length; $i++) {
        $output .= "<th>".$heads[$i]."</th>";
    }

$output .= <<<EOT
    </tr>
    </thead>
EOT;
        foreach ($dataArray as $row) {
            $output .= "<tr>";
            $output .= "<td>" . $row['rid'] . "</td>";
            $output .= "<td>" . $row['score'] . "</td>";
            $output .= "<td>" . $row['foodid'] . "</td>";
            $output .= "<td>" . $row['rateby'] . "</td>";
            $output .= "<td>" . $row['dateconsume'] . "</td>";
            $output .= "</tr>";
        }
    $output .= "</table>";

    return $output;
}