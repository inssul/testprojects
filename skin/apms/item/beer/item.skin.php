<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$item_skin_url.'/style.css" media="screen">', 0);

if($is_orderable) echo '<script src="'.$item_skin_url.'/shop.js"></script>'.PHP_EOL;

?>

<?php echo $it_head_html; // 상단 HTML; ?>

<form name="fitem" method="post" action="<?php echo $action_url; ?>" class="form" role="form" onsubmit="return fitem_submit(this);">
<input type="hidden" name="it_id[]" value="<?php echo $it_id; ?>">
<input type="hidden" name="sw_direct">
<input type="hidden" name="url">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
			<div class="form-box">
				<div class="form-header">
					<h2><strong><i class="fa fa-gift"></i> <?php echo stripslashes($it['it_name']); // 상품명 ?></strong></h2>
				</div>

				<div class="form-body">

					<div class="form-group has-feedback">
						<label><b>구매금액 단위</b></label>
						<input type="text" value="<?php echo display_price(get_price($it)); ?>" class="form-control input-sm" disabled>
						<span class="fa fa-gift form-control-feedback"></span>
						<input type="hidden" id="it_price" value="<?php echo get_price($it); ?>">
					</div>
					<div class="form-group has-feedback">
				        <label><b>아몬드볼</b></label>
						<?php
							if($it['it_point_type'] == 2) {
								$beer_point = '금액의 '.$it['it_point'].'%';
							} else {
								$it_point = get_item_point($it);
								$beer_point = number_format($it_point);
							}
						?>
				        <input type="text" class="form-control input-sm" value="<?php echo $beer_point;?>" disabled>
						<span class="fa fa-gift form-control-feedback"></span>
					</div>
					<div class="form-group">
				        <label><b>수량</b></label>
						<ul id="it_sel_option" style="padding:0px; margin:0px;">
							<?php
							if(!$option_item) {
								if(!$it['it_buy_min_qty'])
									$it['it_buy_min_qty'] = 1;
							?>
								<li id="it_opt_added" class="input-group input-group-sm">
									<input type="hidden" name="io_type[<?php echo $it_id; ?>][]" value="0">
									<input type="hidden" name="io_id[<?php echo $it_id; ?>][]" value="">
									<input type="hidden" name="io_value[<?php echo $it_id; ?>][]" value="<?php echo $it['it_name']; ?>">
									<input type="hidden" class="io_price" value="0">
									<input type="hidden" class="io_stock" value="<?php echo $it['it_stock_qty']; ?>">

									<input type="text" name="ct_qty[<?php echo $it_id; ?>][]" value="<?php echo $it['it_buy_min_qty']; ?>" id="ct_qty_<?php echo $i; ?>" class="form-control input-sm" size="5">
									<span class="input-group-addon">개</span>
									<div class="input-group-btn">
										<button type="button" class="it_qty_plus btn btn-black btn-sm"><i class="fa fa-plus-circle fa-lg"></i><span class="sound_only">증가</span></button>
										<button type="button" class="it_qty_minus btn btn-black btn-sm"><i class="fa fa-minus-circle fa-lg"></i><span class="sound_only">감소</span></button>
									</div>
								</li>

								<script>
								$(function() {
									price_calculate();
								});
								</script>
							<?php } ?>
						</ul>
					</div>

					<p class="btn btn-black btn-block btn-lg">
						<b>
                            <span id="it_tot_price"></span>
                             /
                            <span id="it_tot_point">5,000A</span>
                        </b>
					</p>

                    <div class="well well-sm" style="margin-bottom:10px;">
                        <ul style="padding-left:20px;margin:0;">
                            <li>구매금액에서 부가세를 제외한 금액만큼 아몬드볼이 충전됩니다.</li>
                            <li>상품의 특성상 결제완료 후 취소나 환불이 불가능합니다.</li>
                            <li>회원탈퇴시 회원정보가 삭제되므로 구매하신 아몬드볼은 자동 소멸됩니다.</li>
                        </ul>
                    </div>
                    <label class="cursor">
                        <input name="agree" id="agree" type="checkbox" value="1">
                        상기 내역을 확인하였고, 결제진행에 동의합니다.
                    </label>
					<p  style="margin-top:15px;">
						<input type="submit" onclick="document.pressed=this.value;" value="결제하기" class="btn btn-color btn-block btn-lg" style="font-weight:bold;">
					</p>
				</div>

				<div class="form-footer">
					<p class="text-center">
						<i class="fa fa-gift"></i> 한개당 아몬드볼 5000개가 결제완료 후 충전됩니다.
					</p>
				</div>
			</div>
		</div>
	</div>
</form>

<?php if ($it['it_explan']) { // 상세설명 ?>
	<div class="img-resize">
		<?php echo apms_explan($it['it_explan']); ?>
	</div>
<?php } ?>

<?php echo $it_tail_html; // 하단 HTML ?>

<div class="text-center" style="margin:30px 0px;">
	<a class="btn btn-black btn-sm" href="<?php echo G5_URL;?>">메인으로</a>
</div>

<script>
	// BS3
	$(function() {
		$("select.it_option").addClass("form-control input-sm");
	});

	// 바로구매, 장바구니 폼 전송
	function fitem_submit(f) {
		if (!f.agree.checked) {
			alert("결제진행에 동의하셔야 결제하실 수 있습니다.");
			f.agree.focus();
			return false;
		}

		f.sw_direct.value = 1;

		var val, io_type, result = true;
		var sum_qty = 0;
		var $el_type = $("input[name^=io_type]");

		$("input[name^=ct_qty]").each(function(index) {
			val = $(this).val();

			if(val.length < 1) {
				alert("수량을 입력해 주십시오.");
				result = false;
				return false;
			}

			if(val.replace(/[0-9]/g, "").length > 0) {
				alert("수량은 숫자로 입력해 주십시오.");
				result = false;
				return false;
			}

			if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
				alert("수량은 1이상 입력해 주십시오.");
				result = false;
				return false;
			}

			io_type = $el_type.eq(index).val();
			if(io_type == "0")
				sum_qty += parseInt(val);
		});

		if(!result) {
			return false;
		}

		return true;
	}
</script>
