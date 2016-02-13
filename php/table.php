<?php
/**
 * Created by PhpStorm.
 * User: zachery
 * Date: 2/13/2016
 * Time: 7:26 AM
 */


function genDataTable($name, $dataArray) {
    // print JavaScript for DataTables
    echo <<<EOT
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {
            $('#$name').DataTable();
        } );
    </script>
<table id="$name" class="display">
    <thead>
    <tr>
        <th>Rating ID</th>
        <th>Score</th>
        <th>Food ID</th>
        <th>Rated By ID</th>
        <th>Date Consumed</th>
    </tr>
    </thead>
EOT;
    if (is_array($dataArray)) {
        foreach ($dataArray as $row) {
            echo "<tr>";
            echo "<td>" . $row['rid'] . "</td>";
            echo "<td>" . $row['score'] . "</td>";
            echo "<td>" . $row['foodid'] . "</td>";
            echo "<td>" . $row['rateby'] . "</td>";
            echo "<td>" . $row['dateconsume'] . "</td>";
            echo "</tr>";
        }
    } else {
        print " $dataArray ";
    }
    echo "</table>";

}
/*

<table id="example" class="display">
    <thead>
    <tr>
        <th>Rating ID</th>
        <th>Score</th>
        <th>Food ID</th>
        <th>Rated By ID</th>
        <th>Date Consumed</th>
    </tr>
    </thead>
    <?php foreach($output as $row) : ?>
        <tr>
            <td><?php echo $row['rid']; ?></td>
            <td><?php echo $row['score']; ?></td>
            <td><?php echo $row['foodid']; ?></td>
            <td><?php echo $row['rateby']; ?></td>
            <td><?php echo $row['dateconsume']; ?></td>
        </tr>
    <?php endforeach;?>


*/