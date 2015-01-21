<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/include/check_login.php");?>

<article id="pagecontent">

	<h2>Manage your user profile here.</h2>
		<p>Blahhh</p>
	<nav>
		<span>Links <?php if($ul) {echo 'for '.$un;} ?></span>
		<a href="/user/change-email.php">Change my Email</a>
		<a href="/user/change-pass.php">Change my password</a>
		<a href="/user/recover.php">Recover my account</a>
		<a href="/user/register.php">Register a new account</a>
		<a href="/user/login.php">Login to an existing account</a>
		<a href="/user/logout.php">Logout of the current account</a>
	</nav>

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>