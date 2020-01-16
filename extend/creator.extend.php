<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 해주세요 게시판 만료일 지났을 때 비밀글로 변경
$table_arr = array('creator');
foreach($table_arr as $val) {
    $delete_bo_table = $val;

    $delete_board = sql_fetch(" select * from {$g5['board_table']} where bo_table = '$delete_bo_table' ");
    $sql = " SELECT wr_id, mb_id, wr_1 from {$g5['write_prefix']}{$delete_bo_table} where wr_2 < date_format(now(),'%Y-%m-%d'); "; // state 가 0이고 날짜 지난 게시물 가져오기 
    $result = sql_query($sql);

    $where = '';
    while ($row = sql_fetch_array($result)) {
        $where .= " '".$row['wr_id']."',";

        if ( $row['wr_111'] > 0 ) { // 포인트가 0 이상일 경우에만.
// //                     아이디      ,   포인트    ,    어떤 내용으로 포인트가 다시 갔는지,
            insert_point($row['mb_id'], $row['wr_1'], "해주세요 {$row['wr_id']} 번 글 만료로 아몬드볼 반납 ");

        // 멤버 테이블 포인트 업데이트
            $sql = " SELECT mb_point FROM {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
            $row1 = sql_fetch($sql);
            $res = sql_fetch(" select wr_1 from $write_table where wr_parent = '$wr_id' ");
            $mb_point = $row1['mb_point'] + $row['wr_1'];  //포인트 합계
            sql_query(" update $g5[member_table] set mb_point = '$mb_point' where mb_id = '$member[mb_id]' ");
        }

    }
    $where = substr($where, 0, -1);

    $sql2 = " UPDATE {$g5['write_prefix']}{$delete_bo_table} SET create_state = 3 WHERE wr_id in ( {$where }) "; // 기간 만료 업데이트 0 : 기본(대기), 1 : 완료대기, 2 : 완료, 3 : 기간만료
    sql_query($sql2);

}

?>
