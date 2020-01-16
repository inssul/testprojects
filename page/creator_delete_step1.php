<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($is_guest) {
    alert('회원만 이용하실 수 있습니다.', '/');
}

$creator = $member['creators'];
$step = $member['ct_join_step'];

if ( !$platform ) {
    alert('정상적인 방법으로 접속해주세요.','/');
}

?>

<style>
    .page-content {
        line-height: 22px;
        word-break: keep-all;
        word-wrap: break-word;
    }
    .page-content .article-title {
        color: #0083B9;
        font-weight: bold;
        padding-top: 30px;
        padding-bottom: 10px;
    }
    .page-content ul {
        list-style: none;
        padding: 0;
        margin: 0;
        font-weight: normal;
    }
    .page-content ol {
        margin-top: 0;
        margin-bottom: 15px;
    }
    .page-content p {
        margin: 0 0 15px;
        padding: 0;
    }
    .page-content table {
        border-top: 2px solid #999;
        border-bottom: 1px solid #ddd;
    }
    .page-content td,
    .page-content th {
        line-height: 1.6 !important;
    }
    .page-content table.tbl-center td,
    .page-content table.tbl-center th,
    .page-content td.text-center,
    .page-content th.text-center {
        text-align: center !important;
    }
    .register-term {
        position: relative;
        height: 350px;
        margin: 0px;
        overflow: auto;
    }
</style>

<!-- 회원가입약관 동의 시작 -->
    
<!-- // 소셜로그인 사용시 소셜로그인 버튼 -->
<div><?php @include_once(get_social_skin_path().'/social_register.skin.php'); ?>

</div>



<div class="page-content inner_container delete_step">
    <form method="post" action="/bbs/page.php?hid=creator_delete_step2" onsubmit="return handleAgreeChk()">
        <input type="hidden" name="platform" value="<?php echo $platform?>" />
        <ul class="i_process">
            <li class="active">
                <div>인증삭제 주의사항 / 확인</div>
            </li>
            <li>
                <div>본인 확인</div>
            </li>
            <li>
                <div>삭제 완료</div>
            </li>
        </ul>

        <div class="panel panel-default i_panel_default">
            <div class="panel-heading">
                <strong>인증삭제 주의사항</strong>
            </div>
            <div class="panel-body i_panel_body">
                <div class="register-term i_register_term">
                    <div class="page-content">

                        <div class="article-title i_article_title" style="padding-top:0px;">1. 해주세요 - 크리에이터 이용 불가</div>
                        <p>
                          크리에이터만 답변할 수 있는 카테고리 입니다.<br>
                          삭제를 하게 되면 해당 플랫폼으로 답변이 불가능하며,
                          <br> 플랫폼 인증을 모두 삭제했을 경우 해주세요-크리에이터 카테고리 답변이 아예 불가능합니다.
                        </p>

                        <div class="article-title i_article_title" style="padding-top:0px;">2. 광장 - 인팅룸 ( 크리방 ) 이용 불가</div>
                        <p>
                          크리에이터 끼리의 전용 소통방 입니다.<br>
                          플랫폼 인증을 모두 삭제했을 경우 크리방 이용이 불가능 합니다.
                        </p>

                        <div class="article-title i_article_title" style="padding-top:0px;">3. 삭제 후 동일 정보로 90일간 재인증 불가</div>
                        <p>
                          인증반복을 통한 부정행위를 막기 위하여 인증 삭제 후 해당 인증플랫폼은 90일간 재인증이 불가능 합니다.
                        </p>

                    </div>
                </div>
            </div>

            <div class="panel-footer">
                <label class="checkbox-inline"><input type="checkbox" name="delete_agree" value="1" id="creator_chk_agree"> 인증삭제 주의사항 내용에 동의합니다.</label>
            </div>
        </div>
        <!-- creator check -->

        <div class="creator_join_btns">
            <button type="submit" id="creator_agree_btn">다음</button>
        </div>
    </form>

</div>

<div class="h30"></div>

<script>
    (() => {
        const nextBtn = common._setup('#creator_delete_btn')
        const checkbox = common._setup('#creator_chk_agree')
        
        nextBtn.addEventListener('click', handleAgreeChk)

        function handleAgreeChk(e) {
            if (!checkbox.checked) {
                e.preventDefault()
                alert('인증삭제 주의사항에 동의하셔야 등록신청 하실 수 있습니다.');
            }
        }
    })()
</script>