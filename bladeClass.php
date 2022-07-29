<?php
class Blade
{
    public $title;

    // 更改 title
    function changeTitle($title)
    {
        $this->title = $title;
    }
    // 更改 tag 跟 content
    function changeContent($tag, $content = null, $class = null)
    {
        return "<$tag class=$class>$content</$tag>";
    }

    // 設定 Form
    function form($method, $action, $content = null, $class = null)
    {
        return "<form method='$method' action='$action' class=$class>$content</form>";
    }

    // 設定 Input
    function formInput($tag, $type, $inputName, $placeholder, $class = null, $more = null)
    {
        return "<$tag type='$type' name='$inputName' placeholder='$placeholder' $more class=$class>";
    }

    // 設定 Button
    function formButton($type, $name, $buttonText, $class = null, $more = null)
    {
        return "<button type='$type' name='$name' $more class='$class'>$buttonText</button>";
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
