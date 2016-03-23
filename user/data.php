<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/template/loginwarning.php"); ?>

<article>
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('#all-ratings').DataTable();
        $('#all-foods').DataTable();
    } );
</script>
<div class="container">
    <h4>Data table of all user ratings:</h4>
    <?php
    $mydb = new ckdb;
    $mydb->connect();
    $output1 = $mydb->getRatings($_SESSION['uid']); // get ratings for uID (rateby)
    //$output1 = $mydb->getRatings('0'); // get ratings for uID (rateby)
    //echo print_r($output);
    ?>
    <table id="all-ratings" class="display">
        <thead>
            <tr>
                <th>rated by</th>
                <th>Rate ID</th>
                <th>date consumed</th>
                <th>score</th>
                <th>food id</th>
                <th>food name</th>
                <th>food group</th>
            </tr>
        </thead>
        <?php foreach($output1 as $row1) : ?>
            <tr>
                <td><?php echo $row1['rateby']; ?></td>
                <td><?php echo $row1['rid']; ?></td>
                <td><?php echo $row1['dateconsume']; ?></td>
                <td><?php echo $row1['score']; ?></td>
                <td><?php echo $row1['foodid']; ?></td>
                <td><?php echo $row1['fname']; ?></td>
                <td><?php echo $row1['fgroup']; ?></td>
            </tr>
        <?php endforeach;?>
    </table>

    <hr /> <!-- ##### -->

    <h4>Rating summary per food:</h4>
    <?php
    //$output = $mydb->getRatings($_SESSION['uid']); // get ratings for uID (rateby)
    $output2 = $mydb->getAVGRatingAllFoods('0'); // get ratings for uID (rateby)
    //echo print_r($output);
    ?>
    <table id="all-foods" class="display">
        <thead>
        <tr>
            <th>Food id</th>
            <th>Rated by</th>
            <th>Food name</th>
            <th>Food group</th>
            <th>Average score</th>
        </tr>
        </thead>
        <?php foreach($output2 as $row2) : ?>
            <tr>
                <td><?php echo $row2['foodid']; ?></td>
                <td><?php echo $row2['rateby']; ?></td>
                <td><?php echo $row2['fname']; ?></td>
                <td><?php echo $row2['fgroup']; ?></td>
                <td><?php echo $row2['avgscore']; ?></td>
            </tr>
        <?php endforeach;?>
</div> <!-- /container -->
</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>