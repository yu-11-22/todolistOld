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
$todoList->location = "update.php"; // 設定表單及超連結的 location

// 設定 input 的 accountName
$accountName = 'account';
// 設定 input 的 passwordName
$passwordName = 'password';
// 設定 input 的 checkPasswordName
$checkPasswordName = 'checkpassword';


// 設定 title
$blade->changeTitle("Update");
// 設定 header 標題
$headerContent = $blade->changeContent("h1", "修改密碼");

// 設定帳號 input
$account = $_SESSION['account'];
// 設定帳號區塊
$content1 = $blade->changeContent("div", "帳號：$account", "account");
// 設定密碼 input
$password = $blade->formInput("input", "password", $passwordName, "請修改密碼", null, 'required');
// 設定密碼區塊
$content2 = $blade->changeContent("div", "修改密碼：$password", "password");
// 設定確認密碼 input
$checkpassword = $blade->formInput("input", "password", $checkPasswordName, "請再次確認密碼", null, 'required');
// 設定確認密碼區塊
$content3 = $blade->changeContent("div", "確認密碼：$checkpassword", "password");
// 設定上一頁 button
$back = $blade->formButton("button", "reset", "上一頁", "reset", "onclick=history.back()");
// 設定確認 button
$confirm = $blade->formButton("submit", "submit", "確認", "submit");
// 設定button區塊
$content4 = $blade->changeContent("div", $back . $confirm, "button");
// 設定 content區塊
$indexContent = $blade->form("post", $todoList->location, $content1 . $content2 . $content3 . $content4 . $hidden);

$loginclass->updateTo($account, $passwordName, $checkPasswordName);

$headerClass = "title";
$contentClass = "login";
$footerClass = "";
$title = $blade->title;
$header = $headerContent;
$content = $indexContent;
$footer = "";

// 引入模板
require_once('blade.php');
