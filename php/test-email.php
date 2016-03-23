<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php");?>
<article>
<div class="container">
	<div class="jumbotron">
		<h1>Welcome!</h1>
		<p>Here's some welcome text.</p>
	</div>

	<div class="panel panel-default">
		<h5>Running cksendmail. Output below.</h5>
		<?php
		$output = test_cksendmail();
		echo '<pre>'.$output.'</pre>';
		?>
	</div>
	<div class="panel panel-default">
		<h5>Test Panel</h5>
	</div>

</div> <!-- /container -->
</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>