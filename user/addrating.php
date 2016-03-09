<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php");?>
<article>
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('example').DataTable();
    } );
</script>
<div class="container">
    <div class="page-header">
        <h1>Rate!</h1>
    </div>

    <form class="form-addrating" action="/php/form-handler.php" method="post">
        
        <div class="well well-lg" id="formarea1">
                <label for="food">Food:</label>
                <input list="food" name="food">
                <datalist id="food">
                    <?php
                    $mydb = new ckdb; $mydb->connect();
                    $foodlist = $mydb->getFoods();
                    //print_r($foodlist);
                    foreach ($foodlist as $row) {echo '<option value="'.$row['fname'].'"/>'.$row['fgroup'].'</option>';}
                    ?>
                </datalist>
                <div class="btn-group btn-group-sm" data-toggle="buttons">
                    <label class="btn btn-danger">
                        <input type="radio" name="rating" id="bad" autocomplete="off" checked><span class="glyphicon glyphicon-arrow-down"></span>
                    </label>
                    <label class="btn btn-default active">
                        <input type="radio" name="rating" id="neutral" autocomplete="off" checked><span class="glyphicon glyphicon-minus"></span>
                    </label>
                    <label class="btn btn-success">
                        <input type="radio" name="rating" id="good" autocomplete="off"><span class="glyphicon glyphicon-arrow-up"></span>
                    </label>
                </div>
        </div>
            <input type="hidden" name="type" value="addrating">
            <button class="btn btn-lg btn-primary" type="submit" id="inputSubmit">Save</button>
    </form>


    <hr /> <!-- ##### -->

</div> <!-- /container -->
</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>