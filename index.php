<?php

use JetBrains\PhpStorm\Immutable;

session_start(); // 打開緩沖區，所有來自PHP程序的非文件頭信息均不會發送，而是保存在內部緩沖區
require_once('bladeClass.php');
require_once('crudClass.php');
require_once('todoListClass.php');
require_once('loginClass.php');
require_once('connection/conn_db.php');
$blade = new Blade;
$todoList = new TodoList;
$loginclass = new Login;

$hidden = "<input type='hidden' name='hidden'></input>";
$todoList->location = "index.php"; // 設定表單及超連結的 location

// 設定 input 的 accountName
$accountName = 'account';
// 設定 input 的 passwordName
$passwordName = 'password';


// 設定 title
$blade->changeTitle("Home");
// 設定 header 標題
$headerContent = $blade->changeContent("h1", "會員登入");

// 設定帳號 input
$account = $blade->formInput("input", "account", $accountName, "請輸入帳號", null, 'autofocus ' . 'required');
// 設定帳號區塊
$content1 = $blade->changeContent("div", "帳號：$account", "account");
// 設定密碼 input
$password = $blade->formInput("input", "password", $passwordName, "請輸入密碼", null, 'required');
// 設定密碼區塊
$content2 = $blade->changeContent("div", "密碼：$password", "password");
// 設定註冊 button
$register = $blade->formButton("button", "reset", "註冊", "reset", "onclick=javascript:location.href='register.php'");
// 設定登入 button
$login = $blade->formButton("submit", "submit", "登入", "submit");
// 設定button區塊
$content3 = $blade->changeContent("div", $register . $login, "button");
// 設定 content區塊
$indexContent = $blade->form("post", $todoList->location, $content1 . $content2 . $content3 . $hidden);

$loginclass->loginTo($accountName, $passwordName, $todoList->location);

$headerClass = "title";
$contentClass = "login";
$footerClass = "";
$title = $blade->title;
$header = $headerContent;
$content = $indexContent;
$footer = "";

// 引入模板
require_once('blade.php');
