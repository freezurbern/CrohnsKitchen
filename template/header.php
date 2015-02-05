<!DOCTYPE html><!-- @@ Begin header.php -->
<?php // begin header comment goes behind doctype to prevent IE from complaining.. ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/include/main.php"); ?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Crohn's Kitchen</title>

	<!-- Reset CSS -->
	<link href="/css/reset.css" rel="stylesheet">
	<!-- Bootstrap -->
	<link href="/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Custom CSS for page content -->
	<link href="/css/articles.css" rel="stylesheet">
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/features.js"></script>
	<script type="text/javascript" src="/js/Chart.min.js"></script>
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
		  <a class="navbar-brand" href="/index.php"><img alt="BrandIcon" src="/favicon.ico" width="25" height="25" style="display: inline; margin-top: -5px; margin-right: 5px;">Crohn's Kitchen</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="nav collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <ul class="nav navbar-nav">
			<li><a href="/index.php">Dashboard <span class="sr-only">(current)</span></a></li>
			<li><a href="/add-meal.php">Add Meal</a></li>
			<li><a href="/add-food.php">Add Food</a></li>
			<li><a href="/research.php">Research</a></li>
		  </ul>
		  <ul class="nav navbar-nav navbar-right">
			<li><a href="#">Link</a></li>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php if (isset($ul) && $ul == true) {echo 'Signed in as '.$un;} else {echo "Profile";}?> <span class="caret"></span></a>
			  <?php if (isset($ul) && $ul == true) {echo '
				<ul class="dropdown-menu" role="menu">
				<li><a href="/user/manage.php">Manage</a></li>
				<li><a href="/user/help.php">Help</a></li>
				<li class="divider"></li>
				<li><a href="/user/logout.php">Logout</a></li>
			  </ul>';} else {echo '
			    <ul class="dropdown-menu" role="menu">
				<li><a href="/user/register.php">Sign up for CK!</a></li>
				<li><a href="/user/login.php">Login</a></li>
			  </ul>
			  ';}?>
			</li>
		  </ul>
		</div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
<body>
<!-- @@ End header.php -->
