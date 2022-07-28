<?php
class Blade
{
    public $title;
    public $inputTodoTitle;

    // 更改 title
    function changeTitle($title)
    {
        $this->title = $title;
    }
    // 更改 headerTitle
    function changeheaderTitle($tag, $content = null, $class = null)
    {
        $this->inputTodoTitle = "<$tag class=$class>$content</$tag>";
    }

    // 設定 Form
    function form($method, $action, $content = null, $class = null)
    {
        return "<form method='$method' action='$action' class=$class>$content</form>";
    }

    // 設定 Input
    function formInput($tag, $type, $inputName, $placeholder, $class = null)
    {
        return "<$tag type='$type' name='$inputName' placeholder='$placeholder'  class=$class>";
    }

    // 設定 Button
    function formButton($type, $name, $buttonText, $class = null)
    {
        return "<button type='$type' name='$name' class='$class'>$buttonText</button>";
    }

    // 設定 table
    function table($content = null, $class = null)
    {
        return "<table class='$class'>$content</table>";
    }

    // 設定 tHead
    function tHead($content = null, $class = null)
    {
        return "<thead class='$class'>$content</thead>";
    }

    // 設定 tBody
    function tBody($content = null, $class = null)
    {
        return "<tbody class='$class'>$content</tbody>";
    }

    // 設定 tRow
    function tRow($content = null, $style = null, $class = null)
    {
        return "<tr class='$class' style='$style'>$content</tr>";
    }

    // 設定 thead
    function tableHeader($content = null, $style = null, $class = null)
    {
        return "<th class='$class' style='$style'>$content</th>";
    }

    // 設定 tData
    function tData($content = null, $style = null, $class = null)
    {
        return "<td class='$class' style='$style'>$content</td>";
    }

    // 設定 aHref
    function aHref($content = null, $href = null, $class = null)
    {
        return "<a href='$href' class='$class'>$content</a>";
    }
}

class CRUD extends Blade
{
    function select($tableColumn, $dataTable)
    {
        global $link;
        $sqlString = "SELECT $tableColumn FROM $dataTable";
        $result = mysqli_query($link, $sqlString);
        return $result;
    }

    // 寫入資料
    function insert($dataTable, $tableColumn, $newList)
    {
        global $link;
        $sqlString = "INSERT INTO $dataTable ($tableColumn) VALUES ('$newList')";
        mysqli_query($link, $sqlString);
    }

    // 將指定 id 刪除資料
    function delete($dataTable, $delId)
    {
        global $link;
        $sqlString = "DELETE FROM $dataTable WHERE $dataTable.id={$delId}";
        mysqli_query($link, $sqlString);
    }

    // 將指定 id 更新資料
    function update($dataTable, $tableColumn, $column, $resultRows)
    {
        global $link;
        $sqlString = "UPDATE $dataTable SET $tableColumn='$column' WHERE $dataTable.id=" . $resultRows['id'];
        mysqli_query($link, $sqlString);
        header("location:$this->location"); // 把瀏覽器重新指向
        ob_end_flush(); // 發送內部緩沖區的內容到瀏覽器，并且關閉輸出緩沖區
    }
}

class TodoList extends CRUD
{
    public $alert;
    public $location;
    public $delId;
    public $updateId;
    // 查詢資料並回傳


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
            $this->update("vincent.tasks", "tasks.list", $newList, $resultRows);
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
                $this->tData($resultRows['id']) .
                $this->tData($resultRows['list']) .
                $this->tData(
                    $this->aHref("X", "$this->location?$this->delId=$resultRows[id]")
                ) .
                $this->tData(
                    $this->form(
                        "post",
                        "$this->location",
                        $this->formInput("input", "text", "$this->updateId$resultRows[id]", "輸入更改事項") . $this->formButton("submit", "submit", "確認", "btn")
                    )
                );
            $tRow .= $this->tRow($tDada);
            $this->updateTrow($resultRows);
        }
        $tBody = $this->tBody($tRow);
        return $tBody;
    }
}

$blade = new Blade;
$todoList = new TodoList;
