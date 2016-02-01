<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");
	  require($_SERVER['DOCUMENT_ROOT'] . "/include/check_login.php"); // user login
?>

<article id="pagecontent">
	<?php if($ul) { ?>
	<form action="include/form/new-food.php" method="POST" class="">
	<fieldset>
	<legend>Add a new meal</legend>
		<input type="text" name="name" size="25" placeholder="name of food" required><br>
		<label for="group">Food group</label>
		<select name="group" required>
			<option value="dairy">Dairy</option>
			<option value="fruits">Fruits</option>
			<option value="grains">Grains</option>
			<option value="protein">Protein</option>
			<option value="confections">Confections</option>
			<option value="vegetables">Vegetables</option>
		</select>
		<label for="type">Meal type</label>
		<select name="type" required>
			<option value="breakfast">Breakfast</option>
			<option value="lunch">Lunch</option>
			<option value="dinner">Dinner</option>
			<option value="snack">Snack</option>
			<option value="fourthmeal">Fourth Meal</option>
		</select>
		
		<input type="hidden" name="op" value="addfood">
		<input type="submit" value="Add food!">
	</fieldset>
	</form>
	<?php } else { ?>
		<h2>You're not logged in!</h2>
		<?php echo "DEBUG:".$ul."|".$_SESSION['user'].":"; ?>
	<?php } ?>

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>