<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php");?>
<article>
    <div class="container">

    <?php
    echo "<hr />Creating new ckdb object...<br>";
    $mydb = new ckdb;
    echo "Connecting to database...<br>";
    $mydb->connect();
    echo "Creating test user...<br>";
    $mydb->createUser("zachery@freezurbern.com","MyPassword@123");
    echo "Creating duplicate test user...<br>";
        $mydb->createUser("zachery@freezurbern.com","MyPassword..123");
    echo "Getting foods...<br>";
    $mydb->getFoods();

    echo "Logging in with incorrect password...<br>";
    $mydb->loginUser("zachery@freezurbern.com","MyWrongPassword");
    echo "Logging in with correct password...<br>";
    $mydb->loginUser("zachery@freezurbern.com","MyPassword@123");

    ?>

    </div> <!-- /container -->
</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>
