<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php");?>
<article>
    <div class="container">

    <?php
    echo "<pre>";

    echo "<h5><hr />Creating new ckdb object...<br></h5>";
        $mydb = new ckdb;
    echo "<h5><br>Connecting to database...<br></h5>";
        echo $mydb->connect();
    echo "<h5><br>Creating test user...<br></h5>";
        echo $mydb->createUser("zachery@freezurbern.com","MyPassword@123");
    
    echo "<h5><br>Creating duplicate test user...<br></h5>";
        if( $mydb->createUser("zachery@freezurbern.com","MyPassword@123") ) {
            echo "User Created!";
        } else {
            echo "User not created.";
        }
    echo "<h5><br>Getting foods...<br></h5>";
        echo print_r($mydb->getFoods());
    echo "<h5><br>Getting ratings...<br></h5>";
        echo print_r($mydb->getRatings('0'));
    echo "<h5><br>Getting users...<br></h5>";
        echo print_r($mydb->getUsers());

    echo "<h5><br>Logging in with incorrect password...<br></h5>";
        if ( $mydb->loginUser("zachery@freezurbern.com","MyWrongPassword") ) {
            echo "Login Successful!";
        } else {
            echo "Login FAILURE.";
        }
    echo "<h5><br>Logging in with correct password...<br></h5>";
        if ( $mydb->loginUser("zachery@freezurbern.com","MyPassword@123") ) {
            echo "Login Successful!";
        } else {
            echo "Login FAILURE.";
        }
    echo "<h5><br>Getting uid for zachery@freezurbern.com<br></h5>";
    $uidrows = $mydb->getUserUID("zachery@freezurbern.com");
    //print_r( $uidrows );
    echo "Should be 1.<br>";
    echo "UID = ".$uidrows[0]['uid'];
    echo "</pre>";
    ?>

    </div> <!-- /container -->
</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>
