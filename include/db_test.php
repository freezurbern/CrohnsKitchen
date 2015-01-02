<?php 
require 'db_func.php';

$rows = db_select("SELECT * FROM `test`");
if($rows === false) {
    $error = db_error();
    // Handle error - inform administrator, log to file, show error page, etc.
	die(mysqli_error($connection));
}


$rows = db_select("SELECT * FROM `test`");
if($rows === false) {
    $error = db_error();
    // Handle error - inform administrator, log to file, show error page, etc.
}

echo "<b>Test Data:</b> ";
print_r(array_values($rows));

if ($rows[0]["mynum"] == 5) {echo "<br>Database connection was successful.<br>";} else {echo "Failure.";}



?>