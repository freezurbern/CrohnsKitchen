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

        //require_once("dbconfig.inc.php");
        require_once($_SERVER['DOCUMENT_ROOT'] . "/sql/dbconfig.inc.php");
        try {
            $this->db = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch(PDOException $ex) {
            return $ex->getMessage();
        }
        return "connected to database";

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

        //echo "<br>" . $email . "<br>" . $password . "<br>" . $passHash . "<br>" . $verifykey . "<br>" . $regdate . "<br>";

        try {
        $stmt->execute();
        } catch(PDOException $ex) {
            echo "Exception!";
            return $ex->getMessage();
        }
        echo "good to go.";
        return 0;
    }

    public function loginUser($email, $password) {
        // User provides the password in plain text: $password
        // Password hash created when user signed up is now retrieved from database

        $stmt = $this->db->prepare("SELECT passhash FROM users WHERE email=:email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (isset($rows[0]['passhash'])) {
            $passFromDB = $rows[0]['passhash'];
            // The application will now use password_verify() to recreate the hash and test
            // it against the hash in the database.
            $result = password_verify($password, $passFromDB);
            //if ($result) {
            //    echo 'Password is valid!';
            //} else {
            //    echo 'Invalid password.';
            //}
        } else {
            // No data returned from query, login not successful.
            $result = FALSE;
        }

        $success = ($result) ? 'TRUE': 'FALSE';
        //echo "<br><hr>Successful Login?: ".$success."<br>";
        return $result;
    }

    public function getUser($uid, $email, $createdate) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE uid=:uid");
        $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //print_r($rows);
        return $rows;
    }
    public function getUserUID($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //print_r($rows);
        return $rows;
    }

    public function changeUser($uid, $email, $password) {
        $stmt = $this->db->prepare("UPDATE users SET email=:email, passhash=:passhash WHERE uid=:uid");
        $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':passhash', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $affected_rows = $stmt->rowCount();

        return $affected_rows;
    }
    public function deleteUser($uid, $email) {
        $stmt = $db->prepare("DELETE FROM users WHERE uid=:uid AND email=:email");
        $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $affected_rows = $stmt->rowCount();
        return $affected_rows;
    }

    public function addUserVerify($email) {
    }
    public function delUserVerify($email) {
    }

    public function getFoods() {
        $stmt = $this->db->prepare("SELECT * FROM foods");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    public function getRatings($rateby) {
        $stmt = $this->db->prepare("SELECT * FROM ratings WHERE rateby=:rateby");
        $stmt->bindValue(':rateby', $rateby, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    public function getUsers() {
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //print_r($rows);
        return $rows;
    }

    public function __destruct() {
        // Somehow destroy things here? not needed..
    }
}

?>