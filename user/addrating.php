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

        </div>
            <div id="templaterow" class="formrow" style="display: none;">
                <label for="food1">Food:</label>
                <input list="food1" name="food[]" autocomplete="off">
                <datalist id="food1">
                    <?php
                    foreach ($foodlist as $row) {echo '<option value="'.$row['fname'].'"/>('.$row['fgroup'].')</option>';}
                    ?>
                </datalist>
                <div class="btn-group btn-group-sm" data-toggle="buttons">
                    <label class="btn btn-danger">
                        <input type="radio" name="rating[][bad]" autocomplete="off"><span class="glyphicon glyphicon-arrow-down"></span>
                    </label>
                    <label class="btn btn-default active">
                        <input type="radio" name="rating[][neutral]" id="neutral1" autocomplete="off"><span class="glyphicon glyphicon-minus"></span>
                    </label>
                    <label class="btn btn-success">
                        <input type="radio" name="rating[][good]" id="good1" autocomplete="off"><span class="glyphicon glyphicon-arrow-up"></span>
                    </label>

                    <button type="button" name="delete" class="btn btn-default delete">
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </div>
            </div>
        <button id="add" type="button">Add Field</button>
        <script>
            $(document).ready(function(){
                var $row = $('#templaterow').clone();

                // add first row to form
                $('#formarea1').append($row);
                $('#formarea1').find('.delete').remove();
                $('#formarea1').find('> #templaterow').css("display", "");
                $('#formarea1').find('> #templaterow').removeAttr('id');

                //when the Add Field button is clicked
                $("#add").click(function (e) {
                    //Append a new row of code to the "#items" div
                    var $row = $('#templaterow').clone();
                    $('#formarea1').append($row);
                    $('#formarea1').find('> #templaterow').css("display", "");
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
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>