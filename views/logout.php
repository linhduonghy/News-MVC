<?php
/**
 * Created by PhpStorm.
 * User: Dương Văn Linh
 * Date: 21-08-2018
 * Time: 1:55 PM
 */
include '../index.php';
include controller_path."/user_controller.php";
    $c_user = new user_controller();
    $c_user->logout_controller();
?>