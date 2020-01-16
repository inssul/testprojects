<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($is_guest) {
    alert('회원만 이용하실 수 있습니다.', '/');
}

$creator = $member['creators'];
$step = $member['ct_join_step'];

if ( !$delete_agree ) {
    alert('인증삭제 주의사항에 동의하셔야 합니다.');
}

?>

<div class="page-content inner_container delete_step">
    <form method="post" action="/bbs/page.php?hid=creator_delete_step3" >
        <input type="hidden" name="platform" value="<?php echo $platform?>" />
        <ul class="i_process">
            <li>
                <div>인증삭제 주의사항 / 확인</div>
            </li>
            <li class="active">
                <div>본인 확인</div>
            </li>
            <li>
                <div>삭제 완료</div>
            </li>
        </ul>

        <div class="panel panel-default i_panel_default">
            <div class="panel-heading">
                <strong>인증삭제 본인확인</strong>
            </div>
            <div class="panel-body i_panel_body">
                <div class="register-term i_register_term">
                    <p>- 인증 삭제 신청 후 90일간 재인증이 불가능 합니다.</p>
                    <p>- 인증 정보 입력은 저장되지 않으며, 삭제 후 파기됩니다.</p>

                    <div class="certifi_way">

                        <div class="certifi_phone">
                            <div class="ctf_title">
                                <span>01</span>
                                <b>휴대폰 인증</b>
                            </div>
                            <div class="ctf_body">
                                <p>· 휴대폰 인증 후에 본인 확인을 합니다.</p>
                                <p>· 갖고 계신 휴대폰이 본인 명의가 아닌 경우, 아이핀을 선택해주세요.</p>
                            </div>
                            <div class="ctf_footer">
                                <a href="#" class="cft_phone_btn">인증하기</a>
                            </div>
                        </div>
                        <!-- // certifi_phone -->

                        <div class="certifi_ipin">
                            <div class="ctf_title">
                                <span>02</span>
                                <b>아이핀 (I-PIN) 인증</b>
                            </div>
                            <div class="ctf_body">
                                <p>· 발급받은 아이핀(I-PIN)으로 인증을 합니다.</p>
                                <p>· 아이핀 인증을 선택하시면 아이핀 신규 발급도 바로 가능합니다.</p>
                            </div>
                            <div class="ctf_footer">
                                <a href="#" class="cft_phone_btn">인증하기</a>
                            </div>
                        </div>
                        <!-- // certifi_ipin -->
                    </div>
                    <!-- // certifi_way-->
                </div>
                <!-- // i_register_term -->
            </div>
            <!-- // i_panel_body -->
        </div>
    <!-- // i_panel_default -->

        <div class="text-center btns">
            <a href="#" onclick="history.back()" class="prev">이전페이지</a>
            <button type="submit" class="next">다음</button>
        </div>
    </form>
</div>
<!-- // delete_step -->