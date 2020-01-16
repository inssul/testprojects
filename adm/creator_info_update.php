<?php
include_once('./_common.php');

if ($is_guest)
    alert('회원만 이용하실 수 있습니다.');

if ( $judgment_type == 'y') { // 승인
    $sql = " UPDATE g5_creators SET ".$platform."_is_auth = 2 WHERE ct_id = '".$ct_no."' ";
    sql_query($sql);
    alert("정상적으로 저장 되었습니다.", './creator_info.php?update=ok');
} elseif ( $judgment_type == 'n' ) { // 거절
    $reject_array = '';
    foreach( $reject_reason as $item){
        $reject_array .= $item.',';
    }
    $reject_array = substr($reject_array, 0, -1);
    $sql = " UPDATE g5_creators SET ".$platform."_is_auth = 3, ".$platform."_reject_reason = '".$reject_array."' WHERE ct_id = '".$ct_no."' ";
    sql_query($sql, false);
    alert("정상적으로 저장 되었습니다.", './creator_info.php?update=ok');
} else {
    alert("오류가 있습니다.", './creator_info.php?update=no');
}

?>
