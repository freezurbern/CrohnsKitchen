<!DOCTYPE html><!-- @@ Begin header.php -->
<?php // begin header comment goes behind doctype to prevent IE from complaining.. ?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Crohn's Kitchen</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
  <nav class="navbar navbar-default">
	  <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="#"><img alt="BrandIcon" src="favicon.ico" width="25" height="25" style="display: inline; margin-top: -5px; margin-right: 5px;">Crohn's Kitchen</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <ul class="nav navbar-nav">
			<li class="active"><a href="#">Dashboard <span class="sr-only">(current)</span></a></li>
			<li><a href="#">Add Meal</a></li>
			<li><a href="#">Add Food</a></li>
			<li><a href="#">Research</a></li>
		  </ul>
		  <ul class="nav navbar-nav navbar-right">
			<li><a href="#">Link</a></li>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Signed in as <?php if($ul) {echo 'for '.$un;} ?> <span class="caret"></span></a>
			  <ul class="dropdown-menu" role="menu">
				<li><a href="#">Profile</a></li>
				<li><a href="#">Another action</a></li>
				<li><a href="#">Something else here</a></li>
				<li class="divider"></li>
				<li><a href="#">Separated link</a></li>
			  </ul>
			</li>
		  </ul>
		</div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
<body>
<!-- @@ End header.php -->
