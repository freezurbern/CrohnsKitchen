<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php"); ?>
<article>
    <div class="container">

        <?php
        echo "<pre>";

        echo "<h5><hr />Creating new ckdb object...<br></h5>";
        $mydb = new ckdb;
        echo "<h5><br>Connecting to database...<br></h5>";
        echo $mydb->connect();

        echo "<h5>Deleting previous test user...</h5>";
        $prevUserID = $mydb->getUserUID("zachery@freezurbern.com");
        echo "Previous user ID: " . $prevUserID;
        echo "<br>Success?: ";
        echo var_export($mydb->deleteUser($prevUserID, "zachery@freezurbern.com"), true);

        echo "<h5>Closing link.</h5>";
        echo $mydb = NULL;

        echo "<h5>Reconnecting to database...</h5>";
        $mydb = new ckdb;
        echo $mydb->connect();

        echo "<h5>Does user still exist?</h5>";
        $newuserprevid = $mydb->getUserUID("zachery@freezurbern.com");
        echo "User ID: " . $newuserprevid;

        echo "<h5><br>Creating test user...<br></h5>";
        echo "Success?: ";
        echo var_export($mydb->createUser("zachery@freezurbern.com", "MyPassword@123"), true);

        echo "<h5><br>Creating duplicate test user...<br></h5>";
        $dupuserout = $mydb->createUser("zachery@freezurbern.com", "MyPassword@123");
        echo $dupuserout;
        if ($dupuserout === TRUE) {
            echo "<br />User Created!";
        } else {
            echo "<br />User not created.";
        }
        echo "<h5><br>Getting foods...<br></h5>";
        echo print_r($mydb->getFoods());
        echo "<h5><br>Getting ratings...<br></h5>";
        echo print_r($mydb->getRatings('0'));
        echo "<h5><br>Getting users...<br></h5>";
        echo print_r($mydb->getUsers());

        echo "<h5><br>Logging in without verification...<br></h5>";
        if ($mydb->loginUser("zachery@freezurbern.com", "MyPassword@123")) {
            echo "Login Successful!";
        } else {
            echo "Login FAILURE.";
        }

        echo "<h5><br>Getting verifykey for email zachery@freezurbern.com<br></h5>";
        $userverifycode = $mydb->getUserVerify("zachery@freezurbern.com");
        if($userverifycode) {echo "key present: true<br>";} else {echo "key present: false<br>";}
        echo "Verifykey: ".$userverifycode;
        echo "<h5><br>Verifying user zachery@freezurbern.com<br /></h5>";
        $verified = $mydb->chkUserVerify("zachery@freezurbern.com", $userverifycode);
        echo "Verified: " . $verified;

        echo "<h5><br>Logging in with incorrect password...<br></h5>";
        if ($mydb->loginUser("zachery@freezurbern.com", "MyWrongPassword")) {
            echo "Login Successful!";
        } else {
            echo "Login FAILURE.";
        }
        echo "<h5><br>Logging in with correct password...<br></h5>";
        if ($mydb->loginUser("zachery@freezurbern.com", "MyPassword@123")) {
            echo "Login Successful!";
        } else {
            echo "Login FAILURE.";
        }

        echo "<h5><br>Getting uid for zachery@freezurbern.com<br></h5>";
        $uid = $mydb->getUserUID("zachery@freezurbern.com");
        //print_r( $uidrows );
        echo "Should be > 0: <br>";
        echo "UID = " . $uid;

        echo "<h5><br>Adding verifykey for email zachery@freezurbern.com<br></h5>";
        $userverifyadd = $mydb->addUserVerify("zachery@freezurbern.com");
        echo "Rows affected by addUserVerify: ".$userverifyadd."<br>";
        $userverifycode2 = $mydb->getUserVerify("zachery@freezurbern.com");
        if($userverifycode2) {echo "key present: true<br>";} else {echo "key present: false<br>";}
        echo "Verifykey: ".$userverifycode2;
        echo "<h5><br>Verifying user zachery@freezurbern.com<br /></h5>";
        $verified2 = $mydb->chkUserVerify("zachery@freezurbern.com", $userverifycode2);
        echo "Verified: " . $verified2;

        echo "</pre>";
        ?>

    </div> <!-- /container -->
</article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php"); ?>
