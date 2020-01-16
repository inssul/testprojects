<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

?>
		<?php if($col_name) { ?>
			<?php if($col_name == "two") { ?>
					</div>
					<div class="col-md-<?php echo $col_side;?><?php echo ($at_set['side']) ? ' pull-left' : '';?> at-col at-side">
						<?php include_once($is_side_file); // Side ?>
					</div>
				</div>
			<?php } else { ?>
				</div><!-- .at-content -->
			<?php } ?>
			</div><!-- .at-container -->
		<?php } ?>
	</div><!-- .at-body -->

	<?php if(!$is_main_footer) { ?>
		<footer class="at-footer i_footer">
			<nav class="at-links">
				<div class="at-container">
					<ul class="">
						<li><a href="#">광고문의</a></li>
						<li><a href="#">이용약관</a></li>
						<li><a href="#">개인정보취급방침</a></li>
						<li><a href="#">청소년보호정책</a></li>
						<li><a href="#">책임한계와법적고지</a></li>
						<li><a href="#">저작권보호센터</a></li>
						<li><a href="#">고객센터</a></li>
						<li><a href="#">사이트맵</a></li>
						<!-- <li><a href="</*?php echo G5_BBS_URL;?>/page.php?hid=intro">사이트 소개</a></li> 
						<li><a href="</*?php echo G5_BBS_URL;?>/page.php?hid=provision">이용약관</a></li> 
						<li><a href="</*?php echo G5_BBS_URL;?>/page.php?hid=privacy">개인정보처리방침</a></li>
						<li><a href="</*?php echo G5_BBS_URL;?>/page.php?hid=noemail">이메일 무단수집거부</a></li>
						<li><a href="</*?php echo G5_BBS_URL;?>/page.php?hid=disclaimer">책임의 한계와 법적고지</a></li> -->
					</ul>
					<div class="clearfix"></div>
				</div>
			</nav>
			<div class="at-infos">
				<div class="at-container">
					<?php if(IS_YC) { // YC5 ?>
						<div class="media">
							<div class="media-body">

								<div class="copyright">
									<span>Copynight ⓒ inssul.com All Rights Reserved.</span>
								</div>

								<div class="clearfix"></div>
							</div>
						</div>
					<?php } else { // G5 ?>
						<div class="at-copyright">
							Copynight ⓒ inssul.com All Rights Reserved.
						</div>
					<?php } ?>
				</div>
			</div>
		</footer>
	<?php } ?>
</div><!-- .wrapper -->

<div class="at-go">
	<div id="go-btn" class="go-btn">
		<span class="go-top cursor"><i class="fa fa-chevron-up"></i></span>
		<span class="go-bottom cursor"><i class="fa fa-chevron-down"></i></span>
	</div>
</div>

<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo THEMA_URL;?>/assets/js/respond.js"></script>
<![endif]-->

<!-- JavaScript -->
<script>
var sub_show = "<?php echo $at_set['subv'];?>";
var sub_hide = "<?php echo $at_set['subh'];?>";
var menu_startAt = "<?php echo ($m_sat) ? $m_sat : 0;?>";
var menu_sub = "<?php echo $m_sub;?>";
var menu_subAt = "<?php echo ($m_subsat) ? $m_subsat : 0;?>";
</script>
<script src="<?php echo THEMA_URL;?>/assets/bs3/js/bootstrap.min.js"></script>
<script src="<?php echo THEMA_URL;?>/assets/js/sly.min.js"></script>
<script src="<?php echo THEMA_URL;?>/assets/js/custom.js"></script>
<?php if($is_sticky_nav) { ?>
<script src="<?php echo THEMA_URL;?>/assets/js/sticky.js"></script>
<?php } ?>

<!-- INSSUL APP -->


<?php echo apms_widget('basic-sidebar'); //사이드바 및 모바일 메뉴(UI) ?>

<?php if($is_designer || $is_demo) include_once(THEMA_PATH.'/assets/switcher.php'); //Style Switcher ?>
