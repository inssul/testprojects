<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

if($header_skin)
	include_once('./header.php');

?>

<div class="register_wrap result_skin">

	<ul class="register_process">
		<li>
			<div>약관동의</div>
		</li>
		<li>
			<div>기본 정보 입력</div>
		</li>
		<li class="active">
			<div>가입 인증</div>
		</li>
		<li>
			<div>가입 완료</div>
		</li>
	</ul>

<div class="panel panel-default">
	<!-- <div class="panel-heading"><h4><strong><i class="fa fa-birthday-cake fa-lg"></i> <strong><?php echo $mb['mb_name'] ?></strong>님의 회원가입을 진심으로 축하합니다.</strong></h4></div> -->
	<div class="panel-body">
		<?php if (is_use_email_certify()) {  ?>
			
			<div class="result_message">
				<p class="emphasis">· 입력하신 메일 주소로 발송된 인증 메일을 확인하여 주시기 바랍니다.</p>
				<p>· 발송된 인증 메일은 개인 정보 보호를 위해 3시간 안에 확인해주셔야만 정상적으로 가입이 완료됩니다.</p>
				<p>· 인증 메일을 받지 못하신 경우 인증 메일 재발송을 통해 다시 한번 확인하여 주시기 바랍니다. <a href="#" onclick="alert('지원하지 않는 기능입니다.')">인증 메일 재발송</a></p>
				<p>· 이메일을 잘못 입력하셨다면 회원 가입을 처음부터 다시 진행해 주시기 바랍니다. <a href="/bbs/register.php">회원가입 다시하기</a></p>
			</div>

			<div id="result_email">
				<p class="confirmation"><b>발송된 인증 메일을 확인해 주세요</b></p>
				<p class="confirmation">(인증 유효 시간 : 2019.12.30 21:27 까지)</p>
				<!-- <strong><?php echo $mb['mb_id'] ?></strong><br> -->
				<p class="uesr_email_address"><?php echo $mb['mb_email'] ?></p>

				<a href="#" class="auth_email" target="_blank">인증 메일 확인하기</a>
			</div>
		<?php }  ?>

		<div class="result_message">
			<p>· 메일 제공 업체의 정책에 따라 발송된 메일이 스팸으로 분류될 수도 있으니 스팸 메일함도 확인하여 주시기 바랍니다.</p>
			<p>· 메일에 따라 메일 수신이 일정 시간 지연될 수 있습니다.</p>
		</div>
	</div>
</div>

<?php if($default['de_member_reg_coupon_use'] && get_session('ss_member_reg_coupon') == 1) { ?>
	<div class="well" id="result_coupon">
		<?php echo $mb['mb_name']; ?>님께 주문시 사용하실 수 있는 <strong><?php echo display_price($default['de_member_reg_coupon_price']); ?> 할인<?php echo ($default['de_member_reg_coupon_minimum'] ? '(주문금액 '.display_price($default['de_member_reg_coupon_minimum']).'이상)' : ''); ?> 쿠폰</strong>이 발행됐습니다.<br>
		발행된 할인 쿠폰 내역은 마이페이지에서 확인하실 수 있습니다.
	</div>
<?php } ?>

<!-- <?php if(!$pim) { ?>
	<div class="text-center" style="margin:30px 0px;">
		<a href="<?php echo G5_URL; ?>/" class="btn btn-color" role="button">메인으로</a>
	</div>
<?php } ?> -->

</div>

<script>
	// 이메일 선택 옵션 생성자
	const certifyEmail = CertifyEmail()
</script>