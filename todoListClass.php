<?php
require_once('crudClass.php');
class TodoList extends CRUD
{
    public $alert;
    public $delId;
    public $updateId;
    public $location;

    // 寫入新的待辦事項或跳出錯誤輸入
    function errorInput($tag, $content, $name, $class = null)
    {
        if (isset($_POST['hidden'])) {
            if (empty($_POST[$name])) {
                $this->alert = "<$tag class=$class>$content</$tag>";
            } else {
                $newList = $_POST[$name];
                $this->insert("vincent.tasks", "list", $newList);
            }
        }
    }

    // 判斷 id 刪除列
    function deleteTrow()
    {
        if (isset($_GET[$this->delId])) {
            $delId = $_GET[$this->delId];
            $this->delete("vincent.tasks", $delId);
        }
    }

    // 判斷 id 更新列
    function updateTrow($resultRows)
    {
        if (!empty($_POST[$this->updateId . $resultRows['id']])) {
            $newList = $_POST[$this->updateId . $resultRows['id']];
            $this->update("vincent.tasks", "tasks.list", $newList, "id", $resultRows['id']);
            header("location:$this->location"); // 把瀏覽器重新指向
            ob_end_flush(); // 發送內部緩沖區的內容到瀏覽器，并且關閉輸出緩沖區
        }
    }

    // 印出整個 tBody
    function printTBody()
    {
        $this->deleteTrow();
        $result = $this->select("*", "vincent.tasks");
        $tRow = '';
        while ($resultRows = mysqli_fetch_assoc($result)) {
            $tDada =
                $this->tData($resultRows['id'], "font-size: 20px;") .
                $this->tData($resultRows['list'], "font-size: 20px;") .
                $this->tData(
                    $this->aHref("X", "$this->location?$this->delId=$resultRows[id]")
                ) .
                $this->tData(
                    $this->form(
                        "post",
                        "$this->location",
                        $this->formInput("input", "text", "$this->updateId$resultRows[id]", "輸入更改事項", null, "required") . $this->formButton("submit", "submit", "確認", "btn")
                    )
                );
            $tRow .= $this->tRow($tDada);
            $this->updateTrow($resultRows);
        }
        $tBody = $this->tBody($tRow);
        return $tBody;
    }
}
