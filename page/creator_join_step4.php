<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($is_guest) {
    alert('회원만 이용하실 수 있습니다.', '/');
}


if ( $mo == 'submit' || $mo == 'mod' ) {
    $sql = " update g5_creators set ".$platform."_is_auth = 1 where ct_id = '{$member['mb_no']}' "; // 0 신청전 1대기 2승인 3거절 4재심사
    sql_query($sql);

    $sql = " update {$g5['member_table']} set creators = 1 where mb_no = '{$member['mb_no']}' "; // 0 신청전 1대기 2승 3거절 4재심사
    sql_query($sql);

    // 관리자에게 메일 발송
    include_once(G5_LIB_PATH.'/mailer.lib.php');

    // 관리자 이메일 등록 , 로 구분
    $email_list = "gogosungmin@naver.com, gogosungmin@gmail.com";

    $email = explode(',', $email_list);
    $real_email = array();
    for ($i=0; $i<count($email); $i++){

        if (!preg_match("/([0-9a-zA-Z_-]+)@([0-9a-zA-Z_-]+)\.([0-9a-zA-Z_-]+)/", $email[$i])) continue;

        if ( $mo == 'submit' ) {
            mailer($config['cf_admin_email_name'], $config['cf_admin_email'], trim($email[$i]), '['.$platform.' 플랫폼 등록제출]', '<span style="font-size:9pt;">'.$member['mb_nick'].'님께서 '.$platform.' 플랫폼 등록제출을 하였습니다.<p> <a href="http://inssul.com/adm/creators_list.php">인설에서 확인해주세요.</a><p>'.G5_TIME_YMDHIS.' 에 발송된 메일입니다.</span>', 1);
        } else {
            mailer($config['cf_admin_email_name'], $config['cf_admin_email'], trim($email[$i]), '['.$platform.' 플랫폼 수정제출]', '<span style="font-size:9pt;">'.$member['mb_nick'].'님께서 '.$platform.' 플랫폼 수정제출을 하였습니다.<p> <a href="http://inssul.com/adm/creators_list.php">인썰에서 확인해주세요.</a><p>'.G5_TIME_YMDHIS.' 에 발송된 메일입니다.</span>', 1);
        }
    }
}

$subject = '';

switch($mo) {
    case 'submit':
        $subject = '등록';
        break;
    case 'mod':
        $subject = '수정';
        break;
    case 'del':
        $subject = '삭제';
        break;
}

?>

<div class="page-content register_wrap">

    <ul class="i_process">
        <li>
            <div>약관동의</div>
        </li>
        <li>
            <div>플랫폼 선택</div>
        </li>
        <li>
            <div>정보 입력</div>
        </li>
        <li class="active">
            <div>완료</div>
        </li>
    </ul>

    <div class="complete_step">
      <h2><?php echo $subject?>이 완료 되었습니다.</h2>

      <div class="i_box">
        <p><b>크리에이터 <?php echo $subject?>이 완료되었습니다.<br> 인증 소요기간은 3-7일 정도 소요됩니다.</b></p>
        <br>
        <p>크리에이터로 활발한 활동 부탁드립니다.</p>
        <p>감사합니다.</p>
      </div>

      <a href="/bbs/page.php?hid=creator_join_step2" class="back_btn">확인페이지로</a>
    </div>
</div>