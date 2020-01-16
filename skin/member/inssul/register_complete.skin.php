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
		<li>
			<div>가입 인증</div>
		</li>
		<li class="active">
			<div>가입 완료</div>
		</li>
	</ul>

<div class="panel panel-default">
	<!-- <div class="panel-heading"><h4><strong><i class="fa fa-birthday-cake fa-lg"></i> <strong><?php echo $mb['mb_name'] ?></strong>님의 회원가입을 진심으로 축하합니다.</strong></h4></div> -->
	<div class="panel-body i_complete_body">
		<?php if (is_use_email_certify()) {  ?>

      <h2 class="i_complete_title">가입이 완료 되었습니다.</h2>

			<div id="result_email">
				<p class="confirmation">
          <?php echo $mb['mb_name'] ?>님, 회원가입을 축하합니다.<br/>
          인썰의 새로운 아이디는 <b><?php echo $mb['mb_id'] ?></b> 입니다.
        </p>

        <p>
          소중한 아이디 안전하게 지켜드립니다. <br/>
          감사합니다.
        </p>
			</div>
    <?php }  ?>


    <?php if(!$pim) { ?>
      <div class="text-center" style="margin-top: 60px;">
        <a href="<?php echo G5_URL; ?>/" class="main_btn" role="button">메인으로</a>
      </div>
    <?php } ?>

  </div>

</div>

<?php if($default['de_member_reg_coupon_use'] && get_session('ss_member_reg_coupon') == 1) { ?>
	<div class="well" id="result_coupon">
		<?php echo $mb['mb_name']; ?>님께 주문시 사용하실 수 있는 <strong><?php echo display_price($default['de_member_reg_coupon_price']); ?> 할인<?php echo ($default['de_member_reg_coupon_minimum'] ? '(주문금액 '.display_price($default['de_member_reg_coupon_minimum']).'이상)' : ''); ?> 쿠폰</strong>이 발행됐습니다.<br>
		발행된 할인 쿠폰 내역은 마이페이지에서 확인하실 수 있습니다.
	</div>
<?php } ?>



</div>
