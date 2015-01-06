<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");?>
<article id="pagecontent">

<form action="include/register.php" method="POST" class="skinny">
	<fieldset>
	<legend>Create a new user</legend>
		E-mail: 
			<input type="text" name="email" size="20" placeholder="E-mail" required><br>
		Username: 
			<input type="text" name="user" size="20" placeholder="Username" required><br>
		Password: 
			<input type="password" name="pass" size="20" placeholder="Password" required><br>
		<input type="hidden" name="op" value="new">
		<input type="submit" value="Create user">
	</fieldset>
	</form>

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>