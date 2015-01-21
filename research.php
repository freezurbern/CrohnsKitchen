<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/header.php");?>
<article id="pagecontent">
	<h2>View data as charts here!</h2>
	<p>for now, this page is for testing front end design elements.</p>

	<table>
		<thead>
			<tr>
				<th>fid</th>
				<th>name</th>
				<th>group</th>
			</tr>
		</thead>
		<tbody>
			<tr><td>0</td><td>turkey</td><td>meats</td></tr>
			<tr><td>1</td><td>cheetos</td><td>snacks</td></tr>
			<tr><td>2</td><td>green beans</td><td>vegetables</td></tr>
			<tr><td>3</td><td>baked potato</td><td>vegetables</td></tr>
		</tbody>
	</table>
	<hr />
	<form action="/include/user-manage.php" method="POST" class="skinny">
	<fieldset>
	<legend>Form Title</legend>
		E-mail: 
			<input type="text" name="user" size="20" placeholder="E-mail" required><br>
		Username: 
			<input type="text" name="user" size="20" placeholder="Username" required><br>
		Password: 
			<input type="password" name="pass" size="20" placeholder="Password" required><br>
		<input type="submit" value="Create user">
	</fieldset>
	</form>

	<div class="spacer"></div>
	<hr />
	<!-- Drawing charts using Chart.js -->
	<h2>H2: Creating a bar graph.</h2>
	<p>P: Here is an example using Chart.js.</p>
	<canvas id="myBarChart" width="400" height="400"></canvas>
	<script>
		// Get the context of the canvas element we want to select
		var ctx = document.getElementById("myBarChart").getContext("2d");
		var options = {};
		var data = {
		labels: ["January", "February", "March", "April", "May", "June", "July"],
		datasets: [
		{
			label: "My First dataset",
			fillColor: "#AAA",
			strokeColor: "#999",
			highlightFill: "rgb(255,64,0)",
			highlightStroke: "rgb(196,64,0)",
			data: [65, 59, 80, 81, 56, 55, 40]
		},
		{
			label: "My Second dataset",
			fillColor: "#CCC",
			strokeColor: "#BBB",
			highlightFill: "rgb(255,196,64)",
			highlightStroke: "rgb(255,64,0)",
			data: [28, 48, 40, 19, 86, 27, 90]
		}
		]
		};
		var myBarChart = new Chart(ctx).Bar(data, options);
	</script>
	<hr />
	<h3>H3: Creating a line graph.</h3>
	<canvas id="myLineChart" width="400" height="400"></canvas>
	<script>
		// Get the context of the canvas element we want to select
		var ctx2 = document.getElementById("myLineChart").getContext("2d");
		var options2 = {};
		var data2 = {
		labels: ["January", "February", "March", "April", "May", "June", "July"],
		datasets: [
        {
            label: "My First dataset",
            fillColor: "rgba(140,140,140,0.5)",
            strokeColor: "rgb(255,128,0)",
            pointColor: "rgba(220,220,220,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [65, 59, 80, 81, 56, 55, 40]
        },
        {
            label: "My Second dataset",
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgb(255,64,0)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: [28, 48, 40, 19, 86, 27, 90]
        }
		]
		};
		var myLineChart = new Chart(ctx2).Line(data2, options2);
	</script>
	<hr />
	<h4>H4: Nearly there!</h4>
	<h5>H5: Smallest heading!</h5>
	<p>P: For comparison to above...</p>
	
</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/footer.php");?>