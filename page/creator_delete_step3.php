<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($is_guest) {
    alert('회원만 이용하실 수 있습니다.', '/');
}

$creator = $member['creators'];
$step = $member['ct_join_step'];

    $sql = " update g5_creators set ".$platform."_is_auth = 5 , ".$platform."_delete_day = '".G5_TIME_YMDHIS."' where ct_id = '{$member['mb_no']}' "; // 0 신청전 1대기 2승인 3거절 4재심사
    sql_query($sql, false);

//    $sql = " update {$g5['member_table']} set creators = 1 where mb_no = '{$member['mb_no']}' "; // 0 신청전 1대기 2승 3거절 4재심사
//    sql_query($sql);

// 관리자에게 메일 발송
include_once(G5_LIB_PATH.'/mailer.lib.php');

// 관리자 이메일 등록 , 로 구분
$email_list = "gogosungmin@naver.com, gogosungmin@gmail.com";

$email = explode(',', $email_list);
$real_email = array();
for ($i=0; $i<count($email); $i++){

    if (!preg_match("/([0-9a-zA-Z_-]+)@([0-9a-zA-Z_-]+)\.([0-9a-zA-Z_-]+)/", $email[$i])) continue;

    mailer($config['cf_admin_email_name'], $config['cf_admin_email'], trim($email[$i]), '['.$platform.' 플랫폼 삭제제출]', '<span style="font-size:9pt;">'.$member['mb_nick'].'님께서 '.$platform.' 플랫폼 삭제제출을 하였습니다.<p> <a href="http://inssul.com/adm/creators_list.php">인설에서 확인해주세요.</a><p>'.G5_TIME_YMDHIS.' 에 발송된 메일입니다.</span>', 1);
}


?>

<div class="page-content inner_container delete_step">

    <ul class="i_process">
        <li>
            <div>인증삭제 주의사항 / 확인</div>
        </li>
        <li>
            <div>본인 확인</div>
        </li>
        <li class="active">
            <div>삭제 완료</div>
        </li>
    </ul>

    <div class="complete_step">
      <h2>삭제이 완료 되었습니다.</h2>

      <div class="i_box">
        <p><b>해당플랫폼 크리에이터 인증 삭제가 완료되었습니다<br>인증삭제 플랫폼은 동일정보로 90일간 재인증이 불가능 합니다.</b></p>
        <br>
        <p>감사합니다.</p>
      </div>

      <a href="/bbs/page.php?hid=creator_join_step2" class="back_btn">확인페이지로</a>
    </div>
</div>
<!-- // delete_step -->