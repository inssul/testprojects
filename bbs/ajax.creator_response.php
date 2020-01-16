<?php
include_once('./_common.php');

$subject = strip_tags($_POST['subject']);
$content = strip_tags($_POST['content']);

$mb_no = trim($_POST['mb_no']);

    $sql = " SELECT * FROM g5_creators WHERE ct_id = $mb_no  ";
    $result = sql_fetch($sql);

    echo json_encode($result);

?>