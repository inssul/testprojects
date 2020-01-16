<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

if($header_skin)
	include_once('./header.php');

if($config['cf_social_login_use']) { //소셜 로그인 사용시 

	$social_pop_once = false;

	$self_url = G5_BBS_URL."/login.php";

	//새창을 사용한다면
	if( G5_SOCIAL_USE_POPUP ) {
		$self_url = G5_SOCIAL_LOGIN_URL.'/popup.php';
	}
?>
	<div class="sns-wrap-over" id="sns_register" style="display: none">
		<div class="panel panel-primary">
			<div class="panel-heading"><strong><i class="fa fa-sign-in fa-lg"></i> SNS 계정으로 가입</strong></div>
			<div class="panel-body">
			   <div class="sns-wrap">
					<?php if( social_service_check('naver') ) {     //네이버 로그인을 사용한다면 ?>
					<a href="<?php echo $self_url;?>?provider=naver&amp;url=<?php echo $urlencode;?>" class="sns-icon social_link sns-naver" title="네이버">
						<span class="ico"></span>
						<span class="txt">네이버으로 회원가입하기</span>
					</a>
					<?php }     //end if ?>
					<?php if( social_service_check('kakao') ) {     //카카오 로그인을 사용한다면 ?>
					<a href="<?php echo $self_url;?>?provider=kakao&amp;url=<?php echo $urlencode;?>" class="sns-icon social_link sns-kakao" title="카카오">
						<span class="ico"></span>
						<span class="txt">카카오로 회원가입하기</span>
					</a>
					<?php }     //end if ?>
					<?php if( social_service_check('facebook') ) {     //페이스북 로그인을 사용한다면 ?>
					<a href="<?php echo $self_url;?>?provider=facebook&amp;url=<?php echo $urlencode;?>" class="sns-icon social_link sns-facebook" title="페이스북">
						<span class="ico"></span>
						<span class="txt">페이스북로 회원가입하기</span>
					</a>
					<?php }     //end if ?>
					<?php if( social_service_check('google') ) {     //구글 로그인을 사용한다면 ?>
					<a href="<?php echo $self_url;?>?provider=google&amp;url=<?php echo $urlencode;?>" class="sns-icon social_link sns-google" title="구글">
						<span class="ico"></span>
						<span class="txt">구글+로 회원가입하기</span>
					</a>
					<?php }     //end if ?>
					<?php if( social_service_check('twitter') ) {     //트위터 로그인을 사용한다면 ?>
					<a href="<?php echo $self_url;?>?provider=twitter&amp;url=<?php echo $urlencode;?>" class="sns-icon social_link sns-twitter" title="트위터">
						<span class="ico"></span>
						<span class="txt">트위터로 회원가입하기</span>
					</a>
					<?php }     //end if ?>
					<?php if( social_service_check('payco') ) {     //페이코 로그인을 사용한다면 ?>
					<a href="<?php echo $self_url;?>?provider=payco&amp;url=<?php echo $urlencode;?>" class="sns-icon social_link sns-payco" title="페이코">
						<span class="ico"></span>
						<span class="txt">페이코로 회원가입하기</span>
					</a>
					<?php }     //end if ?>

					<?php if( G5_SOCIAL_USE_POPUP && !$social_pop_once ){
					$social_pop_once = true;
					?>
					<script>
						jQuery(function($){
							$(".sns-wrap").on("click", "a.social_link", function(e){
								e.preventDefault();

								var pop_url = $(this).attr("href");
								var newWin = window.open(
									pop_url, 
									"social_sing_on", 
									"location=0,status=0,scrollbars=1,width=600,height=500"
								);

								if(!newWin || newWin.closed || typeof newWin.closed=='undefined')
									 alert('브라우저에서 팝업이 차단되어 있습니다. 팝업 활성화 후 다시 시도해 주세요.');

								return false;
							});
						});
					</script>
					<?php } ?>

				</div>
			</div>
		</div>
	</div>
<?php } ?>
<!-- 
<div class="alert alert-info" role="alert">
	<strong><i class="fa fa-exclamation-circle fa-lg"></i> 회원가입약관 및 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.</strong>
</div> -->

<div class="register_wrap">

	<ul class="register_process">
		<li class="active">
			<div>약관동의</div>
		</li>
		<li>
			<div>기본 정보 입력</div>
		</li>
		<li>
			<div>가입 인증</div>
		</li>
		<li>
			<div>가입 완료</div>
		</li>
	</ul>

	<form  name="fregister" id="fregister" action="<?php echo $action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off" class="form" role="form">
	<input type="hidden" name="pim" value="<?php echo $pim;?>">
		<div class="panel panel-default i_panel_default">
			<div class="panel-heading"><strong>이용약관</strong></div>
			<div class="panel-body i_panel_body">
				<?php if($provision) { ?>
					<div class="register-term i_register_term">
						<?php echo $provision; ?>
					</div>
				<?php } else { ?>
					<textarea class="form-control input-sm" rows="10" readonly><?php echo get_text($config['cf_stipulation']) ?></textarea>
				<?php } ?>
			</div>
			<div class="panel-footer">
							<label class="checkbox-inline"><input type="checkbox" name="agree" value="1" id="agree11"> 회원가입약관의 내용에 동의합니다.</label>
			</div>
		</div>

		<div class="panel panel-default i_panel_default">
			<div class="panel-heading">
				<?php if($privacy) { ?>
					<!-- <a data-toggle="collapse" href="#privacy" aria-expanded="false" aria-controls="privacy" class="pull-right">전문보기</a> -->
				<?php } ?>
				<strong>개인정보처리방침안내</strong>
			</div>
			<?php if($privacy) { ?>
				<div class="panel-body collapse in i_panel_body" id="privacy">
					<div class="register-term i_register_term">
						<?php echo $privacy; ?>
					</div>
				</div>
			<?php } ?>
			
			<div class="panel-footer">
							<label class="checkbox-inline"><input type="checkbox" name="agree2" value="1" id="agree21" > 개인정보처리방침안내의 내용에 동의합니다.</label>
			</div>
		</div>

			<div class="text-center">
					<button type="submit" class="join_btn">다음</button>
			</div>
	</form>

</div>

<script>
    function fregister_submit(f) {
        if (!f.agree.checked) {
            alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree.focus();
            return false;
        }

        if (!f.agree2.checked) {
            alert("개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree2.focus();
            return false;
        }

        return true;
    }
</script>