<?php

use JetBrains\PhpStorm\Immutable;

ob_start(); // 打開緩沖區，所有來自PHP程序的非文件頭信息均不會發送，而是保存在內部緩沖區
require_once('function.php');
require_once('../connection/conn_db.php');

// 宣告區
$div = "div"; // tag
$input = "input"; // input tag
$text = "text"; // input type
$submit = "submit"; // button type、name
$post = "post"; // form method
$get = "get"; // form method
$hidden = "<input type='hidden' name='hidden'></input>";
$todoList->location = "implement.php"; // 設定表單及超連結的 location

// 設定 input 的 name
$name = 'list';
// 設定 deleteId 的 name
$todoList->delId = "del";
// 設定更改框的 input name
$todoList->updateId = "update";

// 設定 title
$blade->changeTitle("todolist");

// 設定 header 輸入框標題
$blade->changeheaderTitle($div, "待辦事項:", "inputTodo");
// 設定 header input(組)
$headerFormContent = $blade->formInput($input, $text, $name, "輸入待辦事項");
// 設定 header button(組)
$headerFormBtn = $blade->formButton($submit, $submit, "增加事項", "btn");
// 設定 header Form
$headerForm = $blade->form($post, $todoList->location, $headerFormContent . $headerFormBtn . $hidden);
// 設定 header alert 樣式
$todoList->errorInput($div, "請輸入待辦事項", $name, "alert");

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

// 將模板變數宣告
$title = $blade->title;
$inputTodoTitle = $blade->inputTodoTitle;
$inputTodo = $headerForm;
$alert = $todoList->alert;
$content = $contentTable;

// 引入模板
require_once('blade.php');
