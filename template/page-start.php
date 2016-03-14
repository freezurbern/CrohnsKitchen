<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/php/loadobj.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/sql/loadobj.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/php/formcleanup.php");?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="freezurbern">
<link rel="icon" href="/favicon.ico">
<title>Crohn's Kitchen 2.0</title>
<!-- Bootstrap Paper Theme CSS -->
<link href="/css/paper_bootstrap.min.css" rel="stylesheet">
<!-- custom css -->
<link href="/css/main.css" rel="stylesheet">
<!-- Javascript jQuery & BootStrap -->
<script src="/js/jquery-2.2.0.js" type="text/javascript"></script>
<script src="/js/bootstrap.min.js" type="text/javascript"></script>
<!-- DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="/DataTables-1.10.10/css/jquery.dataTables.css"/>
<link rel="stylesheet" type="text/css" href="/DataTables-1.10.10/css/dataTables.bootstrap.css"/>
<script type="text/javascript" src="/DataTables-1.10.10/js/jquery.dataTables.js"></script>
</head>

<nav class="navbar navbar-default">
	<script>
		$(document).ready(function() {
			// get current URL path and assign 'active' class ; https://gist.github.com/daverogers/5375778
			var pathname = window.location.pathname;
			$('.nav > li > a[href="'+pathname+'"]').parent().addClass('active');
			
			// set page title
			var pagetitle = pathname;
			pagetitle = pagetitle.replace('.php', '');
			pagetitle = pagetitle.replace('/', '');
			//console.log('Page Title:'+pagetitle);
			if (pagetitle) {
			document.title = pagetitle+': Crohn\'s Kitchen';
			} else { document.title = 'Crohn\'s Kitchen'; }
		})
	</script>
<div class="container-fluid">
  <div class="navbar-header">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	  <span class="sr-only">Toggle navigation</span>
	  <span class="icon-bar"></span>
	  <span class="icon-bar"></span>
	  <span class="icon-bar"></span>
	</button>
	  <a href="/" class="pull-left"><img src="/favicon.ico"></a>
	<a class="navbar-brand" href="/">Crohn's Kitchen</a>
  </div>
  <div id="navbar" class="navbar-collapse collapse">
	<ul class="nav navbar-nav">
	  <li><a href="/">Dash</a></li>
	  <li><a href="/about.php">About</a></li>
	  <li><a href="/user/addrating.php">Rate foods</a></li>
	</ul>

	<ul class="nav navbar-nav navbar-right">
		<li><a href="./" class="ckorangetxt cklightbg" style="cursor: default !important;"><?php require($_SERVER['DOCUMENT_ROOT'] . "/sitenotice.txt");?><span class="sr-only">(current)</span></a></li>
        <?php if(isset($_SESSION['email'])) { ?>
            <li class="dropdown active">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">User<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class="dropdown-header">
                            <?php echo $_SESSION['email']; ?>
                    </li>
                    <li><a href="/user/index.php">My Profile</a></li>
                    <li><a href="/user/data.php">My Data</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="/user/logout.php">Logout now</a></li>
                </ul>
            </li>
        <?php } else { ?>
            <li><a href="/user/login.php" class="btn-xs btn-primary" style="color: white !important;">Login<span class="sr-only">(current)</span></a></li>
        <?php } ?>
	</ul>
  </div><!--/.nav-collapse -->
</div><!--/.container-fluid -->
</nav>
<body><!-- End page-start -->