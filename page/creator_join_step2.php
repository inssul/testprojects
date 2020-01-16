<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($is_guest) {
    alert('회원만 이용하실 수 있습니다.', '/');
}

if ( $creator_agree == 1 ) { // 동의를 했다면 2로 업데이트
    $sql = " update {$g5['member_table']} set ct_join_step = 2 where mb_no = '{$member['mb_no']}' ";
    sql_query($sql);
}

$mb_no = $member['mb_no'];

$sql = " SELECT * FROM {$g5['member_table']} where mb_no = '{$member['mb_no']}' ";
$row1 = sql_fetch($sql);

//echo $member['mb_no'].'<br/> 11';
//echo $row1['ct_join_step'];

if ( $row1['ct_join_step'] <= 1 ) // 2보다 작으면 동의화면을 패스하고 들어온거임.
    alert('정상적인 방법으로 접속해주세요.', '/bbs/page.php?hid=creator_join_step1');

$sql = " SELECT * FROM g5_creators where  ct_id = $mb_no ";
$row = sql_fetch($sql);


?>

<div class="page-content register_wrap">
    <ul class="i_process">
        <li>
            <div>약관동의</div>
        </li>
        <li class="active">
            <div>플랫폼 선택</div>
        </li>
        <li>
            <div>정보 입력</div>
        </li>
        <li>
            <div>완료</div>
        </li>
    </ul>
    <div class="creator_notice">
        <div class="i_title">
            <h3>자격요건 및 유의사항</h3>
        </div>
        <div class="i_table">
            <div class="i_theader">
                <div>자격요건</div>
                <div>유의사항</div>
            </div>
            <div class="i_tbody">
                <ul>
                    <li>채널개설일 1개월 이상</li>
                    <li>구독자 수 15명 이상</li>
                    <li>동영상 수 10개 이상</li>
                    <li>유튜브, 트위치, 네이버TV, 아프리카TV, 카카오TV 만 가능</li>
                </ul>

                <ul>
                    <li>대시보드와 신청하신 닉네임이 같아야 합니다</li>
                    <li>캡처화면이 흐릿할 경우 승인이 거절될 수 있습니다</li>
                    <li>자격요건에 맞지 않을 경우 승인이 거절될 수 있습니다</li>
                    <li>그 외에 인증방법이 합당하지 않을 경우 승인이 거절될 수 있습니다</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="creator_register_wrap step2">
        <div class="creator_platform">
            <div class="i_title">
                <h3>크리에이터 등록하기</h3>
            </div>
            <?php
            // 플랫폼 종류 추가
            $platform_array = array('youtube', 'twitch', 'kakao', 'naver', 'afreeca');
            foreach ( $platform_array as $item ) :
                $auth = $row[$item.'_is_auth']; ?>
                <div class="creator_platform_list <?php echo $item?>" >
                    <div class="platform_thumbnail">
                        <img src="/custom/images/creator/<?php echo $item ?>.jpg" alt="<?php echo $item ?>">
                    </div>
                    <div class="creator_platform_status">
                        <?php if ( $auth  == 0 ) { // 신청전 ?>
                            <a class="platform_register_btn" href="/bbs/page.php?hid=creator_join_step3&platform=<?php echo $item;?>&mo=submit">등록하기</a>
                        <?php } else if ( $auth == 1 ) { // 대기 ?>
                            <a class="platform_proceeding_btn">심사중</a>
                            <a class="platform_modify_btn" href="/bbs/page.php?hid=creator_join_step3&platform=<?php echo $item;?>&mo=mod">수정</a>
                            <a class="platform_delete_btn" href="/bbs/page.php?hid=creator_delete_step1&platform=<?php echo $item;?>&mo=del">삭제</a>
                        <?php } else if ( $auth == 2 ) { // 승인 ?>
                            <a class="platform_approved_btn">승인</a>
                            <a class="platform_modify_btn" href="/bbs/page.php?hid=creator_join_step3&platform=<?php echo $item;?>&mo=mod">수정</a>
                            <a class="platform_delete_btn" href="/bbs/page.php?hid=creator_delete_step1&platform=<?php echo $item;?>&mo=del">삭제</a>
                        <?php } else if ( $auth == 3 ) { // 거절 ?>
                            <a class="platform_reject_btn">심사거절</a>
                            <a class="platform_retry_btn" href="/bbs/page.php?hid=creator_join_step3&platform=<?php echo $item;?>&mo=mod">수정</a>
                            <a class="platform_delete_btn" href="/bbs/page.php?hid=creator_delete_step1&platform=<?php echo $item;?>&mo=del">삭제</a>
                        <?php } else if ( $auth == 4 ) { // 재심사승인 ?>
                            <a class="platform_approved_btn">승인</a>
                            <a class="platform_modify_btn" href="/bbs/page.php?hid=creator_join_step3&platform=<?php echo $item;?>&mo=mod">수정</a>
                            <a class="platform_delete_btn" href="/bbs/page.php?hid=creator_delete_step1&platform=<?php echo $item;?>&mo=del">삭제</a>
                        <?php } else if ( $auth == 5 ) { // 삭제 후 다시 클릭
                            $delete_day = $row[$item.'_delete_day'];
                            $delete_day = substr($delete_day, 0, 10);
//                            echo $delete_day.'<br/>';
//                            echo date("Y-m-d" , strtotime($delete_day."+90 days") ) ; 90일 후
                            ?>
                            <a class="platform_register_btn" href="/bbs/page.php?hid=creator_join_step3&platform=<?php echo $item;?>&mo=submit">등록하기</a>
                        <?php } ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>