<!DOCTYPE html><!-- @@ Begin header.php -->
<?php // begin header comment goes behind doctype to prevent IE from complaining.. ?>
<html>
<head>
	<title>Crohn's Kitchen</title>
	<link rel="stylesheet" href="/style/reset.css" />
	<link rel="stylesheet" href="/style/template.css" />
	<link rel="stylesheet" href="/style/articles.css"/>
	<script type="text/javascript" src="/js/features.js"></script>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Droid+Sans" />
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
		<li><a href="/user.php?profile">Profile</a></li>
		<li><a href="/user.php?login">Login</a></li>
		<li><a href="/user.php?logout">Logout</a></li>
		</ul>
		<nav>
			<a href="/index.php" id="nav-index" class="navbtn">Main</a>
			<a href="/add-meal.php" id="nav-meal" class="navbtn">Add Meal</a>
			<a href="/add-food.php" id="nav-food" class="navbtn">Add Food</a>
			<a href="/research.php" id="nav-research" class="navbtn">Research</a>
		</nav>
	</header>
<!-- @@ End header.php -->

