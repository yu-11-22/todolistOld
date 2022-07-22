<?php
class TodoList
{
    public $errors = "";
    // 將待辦事項寫進資料庫
    function insertTodo($list)
    {
        global $link;
        $sqlString = "INSERT INTO vincent.tasks (list) VALUES ('$list')";
        mysqli_query($link, $sqlString);
    }

    // 將資料庫指定 id 刪除
    function deleteTodo($delId)
    {
        global $link;
        $sqlString = "DELETE FROM vincent.tasks WHERE tasks.id={$delId}";
        mysqli_query($link, $sqlString);
    }

    // 將指定 id 的內容更新寫入資料庫
    function updateTodo($newList, $resultRows)
    {
        global $link;
        $sqlString = "UPDATE vincent.tasks SET tasks.list='$newList' WHERE tasks.id=" . $resultRows['id'];
        mysqli_query($link, $sqlString);
        header("location:todoList.php"); // 把瀏覽器重新指向
        ob_end_flush(); // 發送內部緩沖區的內容到瀏覽器，并且關閉輸出緩沖區
    }

    // 寫入新的待辦事項或跳出錯誤輸入
    function errorInput()
    {
        if (isset($_POST['hidden'])) {
            if (empty($_POST['list'])) {
                $this->errors = "請輸入待辦事項";
            } else {
                $list = $_POST['list'];
                $this->insertTodo($list);
            }
        }
    }

    // 刪除列
    function deleteTrow()
    {
        if (isset($_GET['delId'])) {
            $delId = $_GET['delId'];
            $this->deleteTodo($delId);
        }
    }
    // 更新列
    function updateTrow($resultRows)
    {
        if (!empty($_POST["newList" . $resultRows['id']])) {
            $newList = $_POST["newList" . $resultRows['id']];
            $this->updateTodo($newList, $resultRows);
        }
    }
}
$todoList = new TodoList;

ob_start(); // 打開緩沖區，所有來自PHP程序的非文件頭信息均不會發送，而是保存在內部緩沖區
require_once('../connection/conn_db.php');

// $errors = "";
$tRow = file_get_contents('tRow.html'); //tRow 樣板
$head = file_get_contents('head.html'); // head 樣板
$blade = file_get_contents('blade.html'); // blade 樣板
$todoList->errorInput();
$todoList->deleteTrow();


// 查找 tasks 表
$sqlString = "SELECT * FROM vincent.tasks";
$result = mysqli_query($link, $sqlString);
$num = mysqli_num_rows($result);

while ($resultRows = mysqli_fetch_assoc($result)) {
    $tRow = str_replace(['{{$id}}', '{{$list}}'], [$resultRows['id'], $resultRows['list']], $tRow); // tRow 樣板更換成資料庫內容
    $num -= 1;
    if ($num > 0) {
        $tRow = $tRow . file_get_contents('tRow.html'); //tRow 樣板增加一次(多一列)
    }
    $todoList->updateTrow($resultRows);
}

echo str_replace(['{{$head}}', '{{$errors}}', '{{$trow}}'], [$head, $todoList->errors, $tRow], $blade); // todoList 樣板更換字串且加入 tr 樣板
