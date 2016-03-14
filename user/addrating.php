<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php"); ?>

<?php
$mydb = new ckdb; $mydb->connect();
$foodlist = $mydb->getFoods();

// form utilities
require($_SERVER['DOCUMENT_ROOT'] . "/php/formcleanup.php");
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

    //echo 'Food Zero|'.$food[0]
    //       .'| Group Zero|'.$food[0]
    //       .'| Rating Good/Nuetral/Bad|'.$rating[0]['good'];

    $f1 = explode(" (", get_post_var('food1') );
    $f1name = $f1[0];
    if(isset($f2[1])) { $f1group = str_replace(")","",$f2[1]); }
    //echo 'f1name: '.$f1name.'<br />f1group: '.$f1group;
    $f2 = explode(" (", get_post_var('food2') );
    $f2name = $f2[0];
    if(isset($f2[1])) { $f2group = str_replace(")","",$f2[1]); }
    //echo 'f2name: '.$f2name.'<br />f2group: '.$f2group;
    $f3 = explode(" (", get_post_var('food3') );
    $f3name = $f3[0];
    if(isset($f3[1])) { $f3group = str_replace(")","",$f3[1]); }
    //echo 'f3name: '.$f3name.'<br />f3group: '.$f3group;
    $f4 = explode(" (", get_post_var('food4') );
    $f4name = $f4[0];
    if(isset($f4[1])) { $f4group = str_replace(")","",$f4[1]); }
    //echo 'f4name: '.$f4name.'<br />f4group: '.$f4group;
    $f5 = explode(" (", get_post_var('food5') );
    $f5name = $f5[0];
    if(isset($f5[1])) { $f5group = str_replace(")","",$f5[1]); }
    //echo 'f5name: '.$f5name.'<br />f5group: '.$f5group;
    $rb1 = get_post_var('rb1'); $rn1 = get_post_var('rn1'); $rg1 = get_post_var('rg1');
    $rb2 = get_post_var('rb2'); $rn2 = get_post_var('rn2'); $rg2 = get_post_var('rg2');
    $rb3 = get_post_var('rb3'); $rn3 = get_post_var('rn3'); $rg3 = get_post_var('rg3');
    $rb4 = get_post_var('rb4'); $rn4 = get_post_var('rn4'); $rg4 = get_post_var('rg4');
    $rb5 = get_post_var('rb5'); $rn5 = get_post_var('rn5'); $rg5 = get_post_var('rg5');
    //foreach ($foodlist as $row) {echo '<option value="'.$row['fname'].'"/>('.$row['fgroup'].')</option>';}

    //$tryAddFood1 = $mydb->addFood();
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