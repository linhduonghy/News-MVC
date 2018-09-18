<?php
/**
 * Created by PhpStorm.
 * User: Dương Văn Linh
 * Date: 16-08-2018
 * Time: 11:03 PM
 */
include "database.php";
class user_model extends database {
    function register_model($name, $email, $password) {
        $sql = "INSERT INTO users(name, email, password) VALUES(?,?,?)";
        $this->setQuery($sql);
        $result = $this->execute(array($name, $email, md5($password)));
        if ($result) {
            return $this->getLastId();
        } else {
            return false;
        }
    }
    function login_model($email, $password) {
        $sql = "SELECT * FROM users WHERE email = '$email' and password = '$password'";
        $this->setQuery($sql);
        return $this->loadRow(array($email, $password));
    }
}
?>