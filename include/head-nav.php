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
<script type="text/javascript" src="/js/jquery.min.js"></script>
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
	<a class="navbar-brand" href="/">Crohn's Kitchen</a>
  </div>
  <div id="navbar" class="navbar-collapse collapse">
	<ul class="nav navbar-nav">
	  <li><a href="/">Dash</a></li>
	  <li><a href="/about.php">About</a></li>
	  <li><a href="/user/login.php">Login</a></li>
	  <li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown<span class="caret"></span></a>
		<ul class="dropdown-menu">
		  <li><a href="#">Action</a></li>
		  <li><a href="#">Another action</a></li>
		  <li><a href="#">Something else here</a></li>
		  <li role="separator" class="divider"></li>
		  <li class="dropdown-header">Nav header</li>
		  <li><a href="#">Separated link</a></li>
		  <li><a href="#">One more separated link</a></li>
		</ul>
	  </li>
	</ul>
	<ul class="nav navbar-nav navbar-right">
	  <li class="active"><a href="./"><?php require($_SERVER['DOCUMENT_ROOT'] . "/sitenotice.txt");?><span class="sr-only">(current)</span></a></li>
	</ul>
  </div><!--/.nav-collapse -->
</div><!--/.container-fluid -->
</nav>