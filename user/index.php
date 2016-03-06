<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php");?>
<article>

<div class="container">
  <div class="jumbotron">
	<h1>User Menu</h1>
	<p>
	  <a class="btn btn-lg btn-primary" href="/user/login.php" role="button">Login now &raquo;</a>
	  <a class="btn btn-lg btn-primary" href="/user/logout.php" role="button">Logout of Account</a>
	  <a class="btn btn-lg btn-primary" href="/user/register.php" role="button">Register &raquo;</a>
	  <a class="btn btn-lg btn-primary" href="/user/data.php" role="button">Data &raquo;</a>
	  <a class="btn btn-lg btn-primary" href="/" role="button">Back to home &raquo;</a>
	</p>
  </div>
</div> <!-- /container -->

</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>