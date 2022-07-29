<?php
require_once('crudClass.php');
class Login extends CRUD
{
    // 驗證登入
    function loginTo($accountName, $passwordName, $errorlocation)
    {
        if (isset($_POST['submit'])) {
            if (!empty($_POST[$accountName]) && !empty($_POST[$passwordName])) {
                $account = $_POST[$accountName];
                $password = $_POST[$passwordName];
                $result = $this->select("*", "vincent.member WHERE member.account='$account'");
                if ($resultRows = mysqli_fetch_assoc($result)) {
                    if (password_verify($password, $resultRows['password'])) {
                        echo '<script>alert("登入成功!");</script>';
                        echo '<script>window.location.href="todoList.php"</script>';
                    } else {
                        echo '<script>alert("帳號或密碼有誤!");</script>';
                        echo "<script>window.location.href=$errorlocation</script>";
                    }
                } else {
                    echo '<script>alert("帳號或密碼有誤!");</script>';
                    echo "<script>window.location.href=$errorlocation</script>";
                }
                $_SESSION['account'] = $account;
            }
        }
    }

    // 驗證註冊
    function registerTo($accountName, $passwordName, $errorlocation)
    {
        if (isset($_POST['submit'])) {
            if (!empty($_POST[$accountName]) && !empty($_POST[$passwordName])) {
                $account = $_POST[$accountName];
                $password = $_POST[$passwordName];
                $password = password_hash($password, PASSWORD_DEFAULT); // 密碼加密
                if ($this->insert("vincent.member", "account, password", "$account','$password")) {
                    echo '<script>alert("註冊成功!");</script>';
                    echo '<script>window.location.href="index.php"</script>';
                } else {
                    echo '<script>alert("帳號已被註冊!");</script>';
                    echo "<script>window.location.href=$errorlocation</script>";
                }
                $_SESSION['account'] = $account;
            }
        }
    }

    // 修改密碼
    function updateTo($account, $passwordName, $checkPasswordName)
    {
        if (isset($_POST['submit'])) {
            $password = $_POST[$passwordName];
            $checkpassword = $_POST[$checkPasswordName];
            if ($password != $checkpassword) {
                echo '<script>alert("兩次密碼不一致，請重新輸入!");</script>';
                echo '<script>window.location.href="update.php"</script>';
            } else {
                $password1 = password_hash($password, PASSWORD_DEFAULT);
                if ($this->update("vincent.member", "member.password", $password1, "account", "'$account'")) {
                    echo '<script>alert("更改完成!");</script>';
                    echo '<script>window.location.href="todoList.php"</script>';
                } else {
                    echo '<script>alert("更改失敗!");</script>';
                    echo '<script>window.location.href="update.php"</script>';
                }
                $_SESSION['account'] = $account;
            }
        }
    }
}
