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
            $this->db->setAttribute(PDO::ATTR_PERSISTENT, true);
        } catch(PDOException $ex) {
            return $ex->getMessage();
        }
        return "connected to database";

    }

    public function createUser($email, $password) {
        if( (strlen($password) >= 8) && (strlen($password) <= 64)) { /* echo "password good"; */ }
            else {return "Password outside minmax 8 to 64";}
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
        } catch(PDOException $ex) { return $ex->getMessage(); }
        //echo "good to go.";
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
        $stmt = $this->db->prepare("SELECT * FROM foods ORDER BY fname, fgroup");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }
    public function addFood($fname, $fgroup, $addby = "0") {
        if(!isset($fname)) { return "Name not set.";}
        if(!isset($fgroup)) { return "Group not set.";}
        /** single insert with bindValue, then execute **/
        $stmt = $this->db->prepare("INSERT INTO foods (fname, fgroup, addby) VALUES (:fname, :fgroup, :addby) ON DUPLICATE KEY UPDATE fname = fname");

        $stmt->bindValue(':fname', $fname, PDO::PARAM_STR);
        $stmt->bindValue(':fgroup', $fgroup, PDO::PARAM_STR);
        $stmt->bindValue(':addby', $addby, PDO::PARAM_STR);

        try {
            $stmt->execute();
        } catch(PDOException $ex) {
            return $ex->getMessage();
        }
        //echo "good to go.";
        return 0;
    }

    public function getRatings($rateby) {
        $stmt = $this->db->prepare("SELECT ratings.rid, ratings.score, ratings.foodid,
            ratings.rateby, ratings.dateconsume, foods.fname, foods.fgroup
            FROM ratings
            INNER JOIN foods
            ON ratings.foodid = foods.fid
            WHERE rateby=:rateby");
        $stmt->bindValue(':rateby', $rateby, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }
    public function getAVGRatingByFood($foodid, $rateby) {
        $stmt = $this->db->prepare("SELECT ratings.foodid, ratings.rateby, foods.fname, foods.fgroup, ROUND(AVG(score),3) AS 'Average Score'
            FROM ratings
            INNER JOIN foods
            ON ratings.foodid = foods.fid
            WHERE rateby=:rateby AND foodid=:foodid");
        $stmt->bindValue(':rateby', $rateby, PDO::PARAM_STR);
        $stmt->bindValue(':foodid', $foodid, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }
    public function getAVGRatingAllFoods($rateby) {
        $stmt = $this->db->prepare("SELECT ratings.foodid, ratings.rateby, foods.fname, foods.fgroup, ROUND(AVG(score),3) AS 'avgscore'
            FROM ratings
            INNER JOIN foods
            ON ratings.foodid = foods.fid
            WHERE rateby=:rateby
            GROUP BY ratings.foodid, ratings.rateby
            ORDER BY foods.fname;");
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