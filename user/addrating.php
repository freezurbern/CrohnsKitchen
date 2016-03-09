<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php"); ?>

<?php
$mydb = new ckdb; $mydb->connect();
$foodlist = $mydb->getFoods();
?>

<article>
<div class="container">
    <div class="page-header">
        <h1>Rate!</h1>
    </div>
        <p class="lead">Add some foods and rate them! Start typing the food name, then select it from the list.</p>
        <p class="lead">If your food is not in the dropdown, simply type it in: <code>NAME (GROUP)</code></p>
    <form class="form-addrating" action="/php/form-handler.php" method="post">
        <div class="well well-lg" id="formarea1">
            <!-- -->
                <label for="food1">Food:</label>
                <input list="food1" name="food1" autocomplete="off">
                <datalist id="food1">
                    <?php
                    foreach ($foodlist as $row) {echo '<option value="'.$row['fname'].'"/>('.$row['fgroup'].')</option>';}
                    ?>
                </datalist>
                <div class="btn-group btn-group-sm" data-toggle="buttons">
                    <label class="btn btn-danger">
                        <input type="radio" name="rb1" id="bad1" autocomplete="off"><span class="glyphicon glyphicon-arrow-down"></span>
                    </label>
                    <label class="btn btn-default active">
                        <input type="radio" name="rn1" id="neutral1" autocomplete="off"><span class="glyphicon glyphicon-minus"></span>
                    </label>
                    <label class="btn btn-success">
                        <input type="radio" name="rg1" id="good1" autocomplete="off"><span class="glyphicon glyphicon-arrow-up"></span>
                    </label>
                </div>
            <!-- --><br />
                <label for="food2">Food:</label>
                <input list="food2" name="food2" autocomplete="off">
                <datalist id="food2">
                    <?php
                    foreach ($foodlist as $row) {echo '<option value="'.$row['fname'].'"/>('.$row['fgroup'].')</option>';}
                    ?>
                </datalist>
                <div class="btn-group btn-group-sm" data-toggle="buttons">
                    <label class="btn btn-danger">
                        <input type="radio" name="rb2" id="bad2" autocomplete="off"><span class="glyphicon glyphicon-arrow-down"></span>
                    </label>
                    <label class="btn btn-default active">
                        <input type="radio" name="rn2" id="neutral2" autocomplete="off"><span class="glyphicon glyphicon-minus"></span>
                    </label>
                    <label class="btn btn-success">
                        <input type="radio" name="rg2" id="good2" autocomplete="off"><span class="glyphicon glyphicon-arrow-up"></span>
                    </label>
                </div>
            <!-- --><br />
                <label for="food3">Food:</label>
                <input list="food3" name="food3" autocomplete="off">
                <datalist id="food3">
                    <?php
                    foreach ($foodlist as $row) {echo '<option value="'.$row['fname'].'"/>('.$row['fgroup'].')</option>';}
                    ?>
                </datalist>
                <div class="btn-group btn-group-sm" data-toggle="buttons">
                    <label class="btn btn-danger">
                        <input type="radio" name="rb3" id="bad3" autocomplete="off"><span class="glyphicon glyphicon-arrow-down"></span>
                    </label>
                    <label class="btn btn-default active">
                        <input type="radio" name="rn3" id="neutral3" autocomplete="off"><span class="glyphicon glyphicon-minus"></span>
                    </label>
                    <label class="btn btn-success">
                        <input type="radio" name="rg3" id="good3" autocomplete="off"><span class="glyphicon glyphicon-arrow-up"></span>
                    </label>
                </div>
            <!-- --><br />
                <label for="food4">Food:</label>
                <input list="food4" name="food4" autocomplete="off">
                <datalist id="food4">
                    <?php
                    foreach ($foodlist as $row) {echo '<option value="'.$row['fname'].'"/>('.$row['fgroup'].')</option>';}
                    ?>
                </datalist>
                <div class="btn-group btn-group-sm" data-toggle="buttons">
                    <label class="btn btn-danger">
                        <input type="radio" name="rb4" id="bad4" autocomplete="off"><span class="glyphicon glyphicon-arrow-down"></span>
                    </label>
                    <label class="btn btn-default active">
                        <input type="radio" name="rn4" id="neutral4" autocomplete="off"><span class="glyphicon glyphicon-minus"></span>
                    </label>
                    <label class="btn btn-success">
                        <input type="radio" name="rg4" id="good4" autocomplete="off"><span class="glyphicon glyphicon-arrow-up"></span>
                    </label>
                </div>
            <!-- --><br />
                <label for="food5">Food:</label>
                <input list="food5" name="food5 autocomplete="off"">
                <datalist id="food5">
                    <?php
                    foreach ($foodlist as $row) {echo '<option value="'.$row['fname'].'"/>('.$row['fgroup'].')</option>';}
                    ?>
                </datalist>
                <div class="btn-group btn-group-sm" data-toggle="buttons">
                    <label class="btn btn-danger">
                        <input type="radio" name="rb5" id="bad5" autocomplete="off"><span class="glyphicon glyphicon-arrow-down"></span>
                    </label>
                    <label class="btn btn-default active">
                        <input type="radio" name="rn5" id="neutral5" autocomplete="off"><span class="glyphicon glyphicon-minus"></span>
                    </label>
                    <label class="btn btn-success">
                        <input type="radio" name="rg5" id="good5" autocomplete="off"><span class="glyphicon glyphicon-arrow-up"></span>
                    </label>
                </div>
            <!-- -->
        </div>
            <input type="hidden" name="type" value="addrating">
            <button class="btn btn-lg btn-primary" type="submit" id="inputSubmit">Save</button>
    </form>


    <hr /> <!-- ##### -->

</div> <!-- /container -->
</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>