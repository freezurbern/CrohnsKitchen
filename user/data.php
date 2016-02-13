<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php");?>
<?php
$mydb = new ckdb;
$mydb->connect();
$output = $mydb->getRatings('0');
echo print_r($output);
?>
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>
<article>
<div class="container">
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
    </table>
</div> <!-- /container -->
</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>