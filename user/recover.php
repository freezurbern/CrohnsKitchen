<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");?>
<article id="pagecontent">

	<form action="include/form-handler.php" method="POST" class="skinny">
	<fieldset>
	<legend>Lost your account?</legend>
		I know my...
		<label>Radio buttons</label>            
          <input type = "radio"
                 name = "radSize"
                 id = "sizeSmall"
                 value = "small"
                 checked = "checked" />
          <label for = "sizeSmall">Username</label>
          
          <input type = "radio"
                 name = "radSize"
                 id = "sizeMed"
                 value = "medium" />
          <label for = "sizeMed">Email</label>
 
          <input type = "radio"
                 name = "radSize"
                 id = "sizeLarge"
                 value = "large" />
          <label for = "sizeLarge">Neither</label>
		  
			<input type="text" name="user" size="20" placeholder="Username" required><br>
		<input type="hidden" name="op" value="recover">
		<input type="submit" value="Change password">
	</fieldset>
	</form>

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>