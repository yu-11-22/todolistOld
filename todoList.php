<?php

use JetBrains\PhpStorm\Immutable;

ob_start(); // 打開緩沖區，所有來自PHP程序的非文件頭信息均不會發送，而是保存在內部緩沖區
require_once('bladeClass.php');
require_once('crudClass.php');
require_once('todoListClass.php');
require_once('loginClass.php');
require_once('connection/conn_db.php');
$blade = new Blade;
$todoList = new TodoList;
$loginclass = new Login;

$hidden = "<input type='hidden' name='hidden'></input>";
$todoList->location = "todoList.php"; // 設定表單及超連結的 location

// 設定 input 的 name
$name = 'list';
// 設定 deleteId 的 name
$todoList->delId = "del";
// 設定更改框的 input name
$todoList->updateId = "update";

// 設定 title
$blade->changeTitle("todolist");

// 設定 header 輸入框標題
$headerContent = $blade->changeContent("div", "待辦事項:", "inputTodo");
// 設定 header input(組)
$headerFormContent = $blade->formInput("input", "text", $name, "輸入待辦事項");
// 設定 header button(組)
$headerFormBtn = $blade->formButton("submit", "submit", "增加事項", "btn");
// 設定 header Form
$headerForm = $blade->form("post", $todoList->location, $headerFormContent . $headerFormBtn . $hidden);
// 設定 header alert 樣式
$todoList->errorInput("div", "請輸入待辦事項", $name, "alert");

// 設定 content tHeader
$tHeader =
    $blade->tableHeader("編號", "width: 100px;") .
    $blade->tableHeader("待辦事項", "width: 500px;") .
    $blade->tableHeader("刪除", "width: 100px;") .
    $blade->tableHeader();
// 設定 content tHeadRow
$tHeadRow = $blade->tRow($tHeader);
// 設定 content tHead
$tHead = $blade->tHead($tHeadRow);

// 呼叫 tBody 方法
$tBody = $todoList->printTBody();

// 設定 table
$contentTable = $blade->table($tHead . $tBody);

// 設定註冊 button
$update = $blade->formButton("button", "reset", "修改", "reset", "onclick=javascript:location.href='update.php'");
// 設定登入 button
$logout = $blade->formButton("submit", "submit", "登出", "submit", "onclick=confirm('確認登出?')");
// 設定button區塊
$content = $blade->changeContent("div", $update . $logout, "button");
// 設定 content區塊
$indexContent = $blade->form("post", "index.php", $content);

// 將模板變數宣告
$headerClass = "header";
$contentClass = "content";
$footerClass = "login";
$title = $blade->title;
$header = $headerContent . $headerForm . $todoList->alert;
$content = $contentTable;
$footer = $indexContent;
// 引入模板
require_once('blade.php');
