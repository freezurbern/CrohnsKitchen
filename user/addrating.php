<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/template/loginwarning.php"); ?>

<?php
$mydb = new ckdb; $mydb->connect();
$foodlist = $mydb->getFoods();
?>

<?php if (!empty($_POST)): ?>
<!-- ##################################################### -->
<!-- ############# AFTER Submission Contents ############# -->
<!-- ##################################################### -->
<article>
<div class="container">
    <div class="page-header">
        <h1>Rating complete!</h1>
    </div>

<?php
    echo "<h5>POST Array:</h5>";
    printArray($_POST);
    echo "<hr />";

    echo "<h5>POST print_r:</h5>";
    print_r($_POST);
    echo "<hr />";

    $food = get_post_var('food');
    if(isset($f2[1])) { $f1group = str_replace(")","",$f2[1]); }
    $rating = get_post_var('rating');

    $f1 = explode(" (", get_post_var('food1') );
    $f1name = $f1[0];
    if(isset($f2[1])) { $f1group = str_replace(")","",$f2[1]); }
    //foreach ($foodlist as $row) {echo '<option value="'.$row['fname'].'"/>('.$row['fgroup'].')</option>';}

    //$tryAddFood1 = $mydb->addFood();

    echo "<h3>For-Each Loop</h3>";
    foreach ($food as $fitem) {
        if (IsNullOrEmptyString($fitem)) {break;}
        echo "Input: <b>".$fitem."</b><br />";
        if (strpos($fitem, ' (') !== false) {
            // Contains a group, break out group to new var
            $fbreak = explode(" (", $fitem );
            $fname = str_replace( "(" ,"", $fbreak[0] );
            if(isset($fbreak[1])) { $fgroup = str_replace(")","",$fbreak[1]); }
        } else {$fname = $fitem; $fgroup = "";}

        echo "Food Name: <b>".$fname."</b><br />&nbsp;&nbsp;&nbsp;&nbsp;Food Group (if specified): <b>".$fgroup."</b><br /><br />";

        if(!in_array($fname, $foodlist)) {
            echo "New food not in list: <b>".$fname."</b>";
            $mydb->addFood($fname, $fgroup, $_SESSION['uid']);
        }

    }
?>

</div>
</article>

<!-- ########################################################### -->
<!-- ########################################################### -->
<?php else: ?>
<!-- ############# Page Content when not submitted ############# -->
<!-- ########################################################### -->
<article>
<div class="container">
    <div class="page-header">
        <h1>Rate!</h1>
    </div>
        <p class="lead">Add some foods and rate them! Start typing the food name, then select it from the list.</p>
        <p class="lead">If your food is not in the dropdown, simply type it in: <code>NAME (GROUP)</code></p>
    <form class="form-addrating" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="well well-lg" id="formarea1">
            <!-- Rows will get put here by the JavaScript function below -->
        </div>
            <div id="templaterow" class="formrow" style="display: none;">
                <label for="food1">Food:</label>
                <input list="food1" name="foodsel" autocomplete="off">
                <datalist id="food1">
                    <?php
                    foreach ($foodlist as $row) {echo '<option value="'.$row['fname'].'"/>('.$row['fgroup'].')</option>';}
                    ?>
                </datalist>
                <div class="btn-group btn-group-sm" data-toggle="buttons">
                    <label class="btn btn-danger">
                        <input type="radio" name="rating" value="bad" autocomplete="off"><span class="glyphicon glyphicon-arrow-down"></span>
                    </label>
                    <label class="btn btn-default active">
                        <input type="radio" name="rating" value="neutral" autocomplete="off"><span class="glyphicon glyphicon-minus"></span>
                    </label>
                    <label class="btn btn-success">
                        <input type="radio" name="rating" value="good" autocomplete="off"><span class="glyphicon glyphicon-arrow-up"></span>
                    </label>

                    <button type="button" name="delete" class="btn btn-default delete">
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </div>
            </div>
        <button id="add" type="button">Add Row</button>
        <script>
            $(document).ready(function(){
                var $row = $('#templaterow').clone();
                var rowcount = 0;

                // add first row to form
                $('#formarea1').append($row);
                $('#formarea1').find('.delete').remove();
                $('#formarea1').find('> #templaterow').css("display", "");
                $('#formarea1').find('> #templaterow').find("input[name*='rating']").attr("name", "rating["+rowcount+"]");
                $('#formarea1').find('> #templaterow').find("input[name*='foodsel']").attr("name", "food["+rowcount+"]");
                $('#formarea1').find('> #templaterow').removeAttr('id');

                //when the Add Field button is clicked
                $("#add").click(function (e) {
                    //Append a new row of code to the "#items" div
                    var $row = $('#templaterow').clone();
                    $('#formarea1').append($row);
                    $('#formarea1').find('> #templaterow').css("display", "");
                    rowcount++;
                    $('#formarea1').find('> #templaterow').find("input[name*='rating']").attr("name", "rating["+rowcount+"]");
                    $('#formarea1').find('> #templaterow').find("input[name*='foodsel']").attr("name", "food["+rowcount+"]");
                    $('#formarea1').find('> #templaterow').removeAttr('id');

                });
                // row delete icon clicked
                $("body").on("click", ".delete", function (e) {
                    $(this).parent().parent().remove();
                });
            });
        </script>
            <input type="hidden" name="type" value="addrating">
            <button class="btn btn-lg btn-primary" type="submit" id="inputSubmit">Save</button>
    </form>


    <hr /> <!-- ##### -->

</div> <!-- /container -->
</article>
<?php endif; ?>

<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>