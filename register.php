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
$todoList->location = "register.php"; // 設定表單及超連結的 location

// 設定 input 的 accountName
$accountName = 'account';
// 設定 input 的 passwordName
$passwordName = 'password';


// 設定 title
$blade->changeTitle("Register");
// 設定 header 標題
$headerContent = $blade->changeContent("h1", "會員註冊");

// 設定帳號 input
$account = $blade->formInput("input", "account", $accountName, "請輸入帳號", null, 'autofocus ' . 'required');
// 設定帳號區塊
$content1 = $blade->changeContent("div", "帳號：$account", "account");
// 設定密碼 input
$password = $blade->formInput("input", "password", $passwordName, "請輸入密碼", null, 'required');
// 設定密碼區塊
$content2 = $blade->changeContent("div", "密碼：$password", "password");
// 設定註冊 button
$index = $blade->formButton("button", "reset", "回首頁", "reset", "onclick=javascript:location.href='index.php'");
// 設定登入 button
$register = $blade->formButton("submit", "submit", "註冊", "submit");
// 設定button區塊
$content3 = $blade->changeContent("div", $index . $register, "button");
// 設定 content區塊
$indexContent = $blade->form("post", $todoList->location, $content1 . $content2 . $content3 . $hidden);

$loginclass->registerTo($accountName, $passwordName, "register.php");

$headerClass = "title";
$contentClass = "login";
$footerClass = "";
$title = $blade->title;
$header = $headerContent;
$content = $indexContent;
$footer = "";

// 引入模板
require_once('blade.php');
