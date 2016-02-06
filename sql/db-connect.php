<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/dbconfig.inc.php");

try {
$db = new PDO('mysql:host='.$config['dbhost'].';dbname='.$config['dbname'], $config['dbuser'], $config['dbpass']);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

foreach($db->query('SELECT * FROM users') as $row) {
    echo 'uID:'.$row['uID'].' email:'.$row['email'];
}
$stmt = $db->query('SELECT * FROM users');
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//use $results
echo '<br>';
print_r(array_values($results));
echo '<br>';
echo $results[0][uid];
echo $results[0][email];
// done
?>