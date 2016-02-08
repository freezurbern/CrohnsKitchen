<?php

/*
 * This file is where the SQL DB object and methods are stored.
*/
class ckdb {
    // define properties
    private $db = "";
    private $dbhost = "";
    private $dbname = "";
    private $dbuser = "";
    private $dbpass = "";

    // define methods


    public function __construct() {

    }

    private function genRndString($length = 64) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function connect() {

        require_once("dbconfig.inc.php");
        $this->db = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    }

    public function createUser($email, $password) {
        /** single insert with bindValue, then execute **/
        $sql_prepare = "INSERT INTO `users` (`email`, `passhash`, `regdate`, `verifykey`) VALUES (:email, :passhash, :regdate, :verifykey)";
        $stmt = $this->db->prepare($sql_prepare);

        $passHash = password_hash($password, PASSWORD_DEFAULT);
        $verifykey = $this->genRndString();
        $regdate = date("Y-m-d H:i:s");

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':passhash',$passHash, PDO::PARAM_STR);
        $stmt->bindValue(':regdate', $regdate, PDO::PARAM_STR);
        $stmt->bindValue(':verifykey', $verifykey, PDO::PARAM_STR);

        $stmt->execute();

        echo "<hr />";
        echo $email;
        echo "<br />";
        echo $password;
        echo "<br />";
        echo $passHash;
        echo "<br />";
        echo $verifykey;
        echo "<br />";
        echo $regdate;
        echo "<hr />";

    }
    public function loginUser($email, $password) {
        // User provides the password in plain text: $password
        // Password hash created when user signed up is now retireved from database

        $stmt = $this->db->prepare("SELECT passhash FROM users WHERE email=:email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $passFromDB = $rows[0]['passhash'];
        // The application will now use password_verify() to recreate the hash and test
        // it against the hash in the database.
        $result = password_verify($password, $passFromDB);
        $success = ($result) ? 'True': 'False';
        //echo "<br><hr>Successful Login?: ".$success."<br>";

        return $result;
    }

    public function getUser($username, $email, $uid, $createdate) {
    }

    public function changeUser($uid, $email, $password) {
        $stmt = $this->db->prepare("UPDATE users SET email=:email WHERE uid=:uid");
        $stmt->execute(array($name, $id));
        $affected_rows = $stmt->rowCount();

        return $affected_rows;
    }

    public function addUserVerify($username) {
    }
    public function delUserVerify($username) {
    }

    public function getFoods() {
        $stmt = $this->db->prepare("SELECT * FROM foods");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //print_r($rows);

        return $rows;
    }

    public function getRatings($uid) {
    }

    public function getUsers() {
    }

    public function __destruct() {

    }
}

$mydb = new ckdb;
$mydb->connect();
//$mydb->getFoods();
//$mydb->createUser("zachery@freezurbern.com","MyPassword@123");

$mydb->loginUser("zachery@freezurbern.com","MyWrongPassword");
$mydb->loginUser("zachery@freezurbern.com","MyPassword@123");
?>