<?php
require_once('../config/config.php');

//引数で与えられた配列をもとにプルダウンリストを生成する
function arrayToSelect($inputName, $srcArray, $selectedIndex = "")
{
    $temphtml = "<select class=\"form-select\" name=\"{$inputName}\">" . PHP_EOL;

    foreach ($srcArray as $key => $val) {
        if ($key == $selectedIndex) {
            $selectedText = "selected";
        } else {
            $selectedText = "";
        }
        $temphtml .= "<option value=\"{$key}\" {$selectedText}>{$val}</option>" . PHP_EOL;
    }

    $temphtml .= "</select>" . PHP_EOL;

    return $temphtml;
}

//引数で与えられた日付を表示形式に変換する
function fomat_date($yyyymmdd)
{
    $week = array('日', '月', '火', '水', '木', '金', '土');
    return date('n/j(' . $week[date('w', strtotime($yyyymmdd))] . ')', strtotime($yyyymmdd));
}
