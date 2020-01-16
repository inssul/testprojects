<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

if ($is_guest)
    alert_close('회원만 이용하실 수 있습니다.');


if ( $update != 'ok' ) {
    $result = sql_query(" SELECT * FROM g5_creators WHERE ct_id = $ct_no ", true );
    $row = sql_fetch_array($result);
}
// 크리에이터 정보 가져오기

// Page ID
$pid = ($pid) ? $pid : '';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 스킨 체크
list($member_skin_path, $member_skin_url) = apms_skin_thema('member', $member_skin_path, $member_skin_url);

// 설정값 불러오기
$is_memo_sub = true;
@include_once($member_skin_path.'/config.skin.php');

$g5['title'] = $mb_nick.' 님의 크리에이터 제출 정보 ';

if($is_memo_sub) {
    include_once(G5_PATH.'/head.sub.php');
    if(!USE_G5_THEME) @include_once(THEMA_PATH.'/head.sub.php');
} else {
    include_once('./_head.php');
}

$skin_path = $member_skin_path;
$skin_url = $member_skin_url;

// 스킨설정
$wset = (G5_IS_MOBILE) ? apms_skin_set('member_mobile') : apms_skin_set('member');

$setup_href = '';
if(is_file($skin_path.'/setup.skin.php') && ($is_demo || $is_designer)) {
    $setup_href = './skin.setup.php?skin=member&amp;ts='.urlencode(THEMA);
}

$action_url = G5_HTTPS_BBS_URL."/memo_form_update.php";
include_once($skin_path.'/creator_info.skin.php');

if($is_memo_sub) {
    if(!USE_G5_THEME) @include_once(THEMA_PATH.'/tail.sub.php');
    include_once(G5_PATH.'/tail.sub.php');
} else {
    include_once('./_tail.php');
}
?>
