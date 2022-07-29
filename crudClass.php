<?php
require_once('bladeClass.php');
class CRUD extends Blade
{
    // 查詢資料並回傳
    function select($tableColumn, $dataTable)
    {
        global $link;
        $sqlString = "SELECT $tableColumn FROM $dataTable";
        $result = mysqli_query($link, $sqlString);
        return $result;
    }

    // 寫入資料
    function insert($dataTable, $tableColumn, $A)
    {
        global $link;
        $sqlString = "INSERT INTO $dataTable ($tableColumn) VALUES ('$A')";
        $result = mysqli_query($link, $sqlString);
        return $result;
    }

    // 將指定 id 刪除資料
    function delete($dataTable, $delId)
    {
        global $link;
        $sqlString = "DELETE FROM $dataTable WHERE $dataTable.id={$delId}";
        mysqli_query($link, $sqlString);
    }

    // 更新資料
    function update($dataTable, $tableColumn, $column, $name, $resultRows)
    {
        global $link;
        $sqlString = "UPDATE $dataTable SET $tableColumn='$column' WHERE $dataTable.$name=" . $resultRows;
        $result = mysqli_query($link, $sqlString);
        return $result;
    }
}
