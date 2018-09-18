<?php
/**
 * Created by PhpStorm.
 * User: Dương Văn Linh
 * Date: 20-08-2018
 * Time: 11:26 PM
 */
session_start();
include model_path."/user_model.php";
class user_controller {
    function register_controller($name, $email, $password) {
        $m_user = new user_model();
        $id_user_register = $m_user->register_model($name, $email, $password);
        if ($id_user_register > 0) {
            $_SESSION['register_success'] = 'Đăng ký thành công';
            if (isset($_SESSION['register_error'])) {
                unset($_SESSION['register_error']);
            }
            header('location:index.php');
        }
        else {
            $_SESSION['register_error'] = 'Đăng ký không thành công';
            header('location:register.php');
        }
    }
    function login_controller($email, $password) {
        $m_user = new user_model();
        $user_login = $m_user->login_model($email, $password);
        if ($user_login == true) {
            $_SESSION['name'] = $user_login->name;
            $_SESSION['id'] = $user_login->id;
            $_SESSION['login_success'] = "Đăng nhập thành công";
            if(isset($_SESSION['login_error'])) {
                unset($_SESSION['login_error']);
            }
            header('location:index.php');
        }
        else {
            $_SESSION['login_error'] = "Đăng nhập thất bại";
            header('location:login.php');
        }
    }
    function logout_controller() {
        session_destroy();
        header('location:index.php');
    }

}
?>