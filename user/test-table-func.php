<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php");?>
<article>
<div class="container">
<?php
/**
 * Created by PhpStorm.
 * User: zachery
 * Date: 2/13/2016
 * Time: 7:36 AM
 */

require_once($_SERVER['DOCUMENT_ROOT'] . "/php/table.php");

$mydb = new ckdb;
$mydb->connect();
$output = $mydb->getRatings('0');
echo genDataTable("mydata",$output);

?>


</div> <!-- /container -->
</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>