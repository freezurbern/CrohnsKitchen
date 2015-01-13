<!DOCTYPE html><!-- @@ Begin header.php -->
<?php // begin header comment goes behind doctype to prevent IE from complaining.. ?>
<html>
<head>
	<title>Crohn's Kitchen</title>
	<link rel="stylesheet" type="text/css" href="/style/reset.css" />
	<link rel="stylesheet" type="text/css" href="/style/template.css" />
	<link rel="stylesheet" type="text/css" href="/style/articles.css" />
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Sans" />
	<script type="text/javascript" src="/js/features.js"></script>
	<script type="text/javascript" src="/js/Chart.js"></script>
	<script type="text/javascript" src='https://www.google.com/recaptcha/api.js'></script>
	<meta charset="utf-8"/>
</head>
<?php
	/* The body ID is found using the end of the url like so: http://crohns.zachery.ninja/index.php -> index */
	$pagename = basename($_SERVER['REQUEST_URI'], ".php");
	if (empty($pagename)) {$pagename = "index";}
?>
<body id="<?php echo $pagename;?>">
	<header>
		<h1>Crohn's Kitchen</h1>
		<h2>eat bits, not bytes!</h2>
		<ul>
		<li><span class="special">Quick Links</span></li>
		<li><a href="/user/manage.php">Profile</a></li>
		<li><a href="/user/login.php">Login</a></li>
		<li><a href="/user/logout.php">Logout</a></li>
		</ul>
		<nav>
			<a href="/index.php" id="nav-index" class="navbtn">Main</a>
			<a href="/add-meal.php" id="nav-meal" class="navbtn">Add Meal</a>
			<a href="/add-food.php" id="nav-food" class="navbtn">Add Food</a>
			<a href="/research.php" id="nav-research" class="navbtn">Research</a>
		</nav>
	</header>
<!-- @@ End header.php -->

