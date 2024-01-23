<?php
function getWeekday($date) {
    $week = array("日", "月", "火", "水", "木", "金", "土");
    $index = date("w", strtotime($date));
    return $week[$index];
}