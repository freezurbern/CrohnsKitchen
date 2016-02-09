<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php");?>
<article>
    <div class="container">

    <?php
    echo "<h5><hr />Creating new ckdb object...<br></h5>";
        $mydb = new ckdb;
    echo "<h5><br>Connecting to database...<br></h5>";
        echo $mydb->connect();
    echo "<h5><br>Creating test user...<br></h5>";
        echo $mydb->createUser("zachery@freezurbern.com","MyPassword@123");
    
    echo "<h5><br>Creating duplicate test user...<br></h5>";
        $mydb->createUser("zachery@freezurbern.com","MyPassword..123");
    echo "<h5><br>Getting foods...<br></h5>";
        echo $mydb->getFoods();
    echo "<h5><br>Getting ratings...<br></h5>";
    echo $mydb->getRatings('0');
    echo "<h5><br>Getting users...<br></h5>";
    echo $mydb->getUsers();

    echo "<h5><br>Logging in with incorrect password...<br></h5>";
        echo $mydb->loginUser("zachery@freezurbern.com","MyWrongPassword");
    echo "<h5><br>Logging in with correct password...<br></h5>";
        echo $mydb->loginUser("zachery@freezurbern.com","MyPassword@123");

    ?>

    </div> <!-- /container -->
</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>
