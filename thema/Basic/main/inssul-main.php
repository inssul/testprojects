<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 위젯 대표아이디 설정
$wid = 'CMB';

// 게시판 제목 폰트 설정
$font = 'font-16 en';

// 게시판 제목 하단라인컬러 설정 - red, blue, green, orangered, black, orange, yellow, navy, violet, deepblue, crimson..
$line = 'navy';

// 사이드 위치 설정 - left, right
$side = ($at_set['side']) ? 'left' : 'right';

?>
<style>
	.widget-index .at-main,
	.widget-index .at-side { padding-bottom:0px; }
	.widget-index .div-title-underbar { margin-bottom:15px; }
	.widget-index .div-title-underbar span { padding-bottom:4px; }
	.widget-index .div-title-underbar span b { font-weight:500; }
	.widget-index .widget-img img { display:block; max-width:100%; /* 배너 이미지 */ }
	.widget-box { margin-bottom:25px; }
</style>

<div class="at-container widget-index">

	<div class="h20"></div>

	<?php echo apms_widget('basic-title', $wid.'-wt1', 'height=260px', 'auto=0'); //타이틀 ?>

	<div class="row at-row">
		<!-- 메인 영역 -->
		<div class="col-md-9<?php echo ($side == "left") ? ' pull-right' : '';?> at-col at-main">


			<!-- 해주세요 시작 -->
			<div class="div-title-underbar">
				<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=please">
					<span class="pull-right lightgray <?php echo $font;?>">+</span>
					<span class="board_underbar border-<?php echo $line;?> <?php echo $font;?>">
						<b>해주세요</b>
					</span>
				</a>
			</div>
			<div class="widget-box">
				<?php echo apms_widget('inssul-gallery-please', 'please-'.$wid.'-wm1', 'icon={아이콘:caret-right} date=1 center=1 strong=1,2'); ?>
			</div>
			<!-- 해주세요 끝 -->	
			

			<div class="row">
				<div class="col-sm-6">

					<!-- 인기BEST 시작-->
					<div class="div-title-underbar">
						<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=popular_best">
							<span class="pull-right lightgray <?php echo $font;?>">+</span>
							<span class="board_underbar border-<?php echo $line;?> <?php echo $font;?>">
								<b>인기BEST</b>
							</span>
						</a>
					</div>
					<div class="widget-box">
						<?php echo apms_widget('basic-post-mix', 'popular-'.$wid.'-wm1', 'icon={아이콘:caret-right} date=1 center=1 strong=1,2'); ?>
					</div>
					<!-- 인기BEST 끝-->

				</div>

				<div class="col-sm-6">
					<!-- 이슈BEST 시작 -->
					<div class="div-title-underbar">
						<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=issue_best">
							<span class="pull-right lightgray <?php echo $font;?>">+</span>
							<span class="board_underbar border-<?php echo $line;?> <?php echo $font;?>">
								<b>이슈BEST</b>
							</span>
						</a>
					</div>
					<div class="widget-box">
						<?php echo apms_widget('basic-post-mix', 'issue-'.$wid.'-wm2', 'icon={아이콘:caret-right} date=1 center=1 strong=1,2'); ?>
					</div>
					<!-- 이슈BEST 끝 -->
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<!-- 인TALK 시작 -->
					<div class="div-title-underbar">
						<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=in_talk">
							<span class="pull-right lightgray <?php echo $font;?>">+</span>
							<span class="board_underbar border-<?php echo $line;?> <?php echo $font;?>">
								<b>인TALK</b>
							</span>
						</a>
					</div>
					<div class="widget-box">
						<?php echo apms_widget('basic-post-list', 'in_talk-'.$wid.'-wm2', 'icon={아이콘:caret-right} date=1 center=1 strong=1,2'); ?>
					</div>
					<!-- 인TALK 끝 -->
				</div>

				<div class="col-sm-6">
					<!-- 일상TALK 시작 -->
					<div class="div-title-underbar">
						<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=daily_talk">
							<span class="pull-right lightgray <?php echo $font;?>">+</span>
							<span class="board_underbar border-<?php echo $line;?> <?php echo $font;?>">
								<b>일상TALK</b>
							</span>
						</a>
					</div>
					<div class="widget-box">
						<?php echo apms_widget('basic-post-list', 'daily_talk-'.$wid.'-wm2', 'icon={아이콘:caret-right} date=1 center=1 strong=1,2'); ?>
					</div>
					<!-- 일상TALK 끝 -->
				</div>
			</div>


			<!-- 꿀잼놀이터 시작 -->
			<div class="div-title-underbar">
				<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=playground">
					<span class="pull-right lightgray <?php echo $font;?>">+</span>
					<span class="board_underbar border-<?php echo $line;?> <?php echo $font;?>">
						<b>꿀잼놀이터</b>
					</span>
				</a>
			</div>
			<div class="widget-box">
				<?php echo apms_widget('inssul-gallery-playground', 'playground-'.$wid.'-wm1', 'icon={아이콘:caret-right} date=1 center=1 strong=1,2'); ?>
			</div>
			<!-- 꿀잼놀이터 끝 -->	

			<!-- 모집합니다 시작 -->
			<div class="div-title-underbar">
				<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=recruit">
					<span class="pull-right lightgray <?php echo $font;?>">+</span>
					<span class="board_underbar border-<?php echo $line;?> <?php echo $font;?>">
						<b>모집합니다</b>
					</span>
				</a>
			</div>
			<div class="widget-box">
				<?php echo apms_widget('inssul-gallery-recruit', 'recruit-'.$wid.'-wm1', 'icon={아이콘:caret-right} date=1 center=1 strong=1,2'); ?>
			</div>
			<!-- 모집합니다 끝 -->

				<!-- 좋아요와구독 시작 -->
				<div class="div-title-underbar">
				<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=like_subs">
					<span class="pull-right lightgray <?php echo $font;?>">+</span>
					<span class="board_underbar border-<?php echo $line;?> <?php echo $font;?>">
						<b>좋아요와구독</b>
					</span>
				</a>
			</div>
			<div class="widget-box">
				<?php echo apms_widget('basic-post-gallery', 'like_subs-'.$wid.'-wm1', 'icon={아이콘:caret-right} date=1 center=1 strong=1,2'); ?>
			</div>
			<!-- 좋아요와구독 끝 -->

			
		</div>
		<!-- 사이드 영역 -->
		<div class="col-md-3<?php echo ($side == "left") ? ' pull-left' : '';?> at-col at-side">

			<?php if(!G5_IS_MOBILE) { //PC일 때만 출력 ?>
				<div class="hidden-sm hidden-xs">
					<!-- 로그인 시작 -->
					<div class="div-title-underbar">
						<span class="board_underbar border-<?php echo $line;?> <?php echo $font;?>">
							<b><?php echo ($is_member) ? 'Profile' : 'Login';?></b>
						</span>
					</div>

					<div class="widget-box">
						<?php echo apms_widget('basic-outlogin'); //외부로그인 ?>
					</div>
					<!-- 로그인 끝 -->
				</div>
			<?php } ?>

			<div class="row">
				<div class="col-md-12 col-sm-6">

					<!-- 알림 시작 -->
					<div class="div-title-underbar">
						<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=basic">
							<span class="pull-right lightgray <?php echo $font;?>">+</span>
							<span class="board_underbar border-<?php echo $line;?> <?php echo $font;?>">
								<b>Notice</b>
							</span>
						</a>
					</div>
					<div class="widget-box">
						<?php echo apms_widget('basic-post-list', $wid.'-ws1', 'icon={아이콘:bell} date=1 strong=1,3'); ?>
					</div>
					<!-- 알림 끝 -->
			
				</div>
				<div class="col-md-12 col-sm-6">

					<!-- 댓글 시작 -->
					<div class="div-title-underbar">
						<a href="<?php echo $at_href['new'];?>?view=c">
							<span class="pull-right lightgray <?php echo $font;?>">+</span>
							<span class="board_underbar border-<?php echo $line;?> <?php echo $font;?>">
								<b>Comments</b>
							</span>
						</a>
					</div>
					<div class="widget-box">
						<?php echo apms_widget('basic-post-list', $wid.'-ws2', 'icon={아이콘:comment} comment=1 date=1 strong=1,2'); ?>
					</div>
					<!-- 댓글 끝 -->
		
				</div>
			</div>

			<!-- 광고 시작 -->
			<div class="widget-box">
				<div style="width:100%; min-height:280px; line-height:280px; text-align:center; background:#f5f5f5;">
					반응형 구글광고 등
				</div>
			</div>
			<!-- 광고 끝 -->

			<!-- 랭킹 시작 -->
			<div class="div-title-underbar">
				<span class="board_underbar border-<?php echo $line;?> <?php echo $font;?>">
					<b>Rank</b>
				</span>
			</div>
			<div class="widget-box">
				<?php echo apms_widget('basic-member', $wid.'-wr1', 'cnt=1 rank=navy ex_grade=10'); ?>
			</div>
			<!-- 랭킹 끝 -->

			<!-- 설문 시작 -->
			<?php // 설문조사
				$is_poll_list = apms_widget('basic-poll', $wid.'-ws3', 'icon={아이콘:commenting}');
				if($is_poll_list) {
			?>
				<div class="div-title-underbar">
					<span class="board_underbar border-<?php echo $line;?> <?php echo $font;?>">
						<b>Poll</b>
					</span>
				</div>
				<div class="widget-box">
					<?php echo $is_poll_list; ?>
				</div>					
			<?php } ?>
			<!-- 설문 끝 -->

			<!-- 통계 시작 -->
			<div class="div-title-underbar">
				<span class="board_underbar border-<?php echo $line;?> <?php echo $font;?>">
					<b>State</b>
				</span>
			</div>
			<div class="widget-box">
				<ul style="padding:0; margin:0; list-style:none;">
					<li><i class="fa fa-bug red"></i>  <a href="<?php echo $at_href['connect'];?>">
						현재 접속자 <span class="pull-right"><?php echo number_format($stats['now_total']); ?><?php echo ($stats['now_mb'] > 0) ? '(<b>'.number_format($stats['now_mb']).'</b>)' : ''; ?> 명</span></a>
					</li>
					<li><i class="fa fa-bug"></i> 오늘 방문자 <span class="pull-right"><?php echo number_format($stats['visit_today']); ?> 명</span></li>
					<li><i class="fa fa-bug"></i> 어제 방문자 <span class="pull-right"><?php echo number_format($stats['visit_yesterday']); ?> 명</span></li>
					<li><i class="fa fa-bug"></i> 최대 방문자 <span class="pull-right"><?php echo number_format($stats['visit_max']); ?> 명</span></li>
					<li><i class="fa fa-bug"></i> 전체 방문자 <span class="pull-right"><?php echo number_format($stats['visit_total']); ?> 명</span></li>
					<li><i class="fa fa-bug"></i> 전체 게시물	<span class="pull-right"><?php echo number_format($menu[0]['count_write']); ?> 개</span></li>
					<li><i class="fa fa-bug"></i> 전체 댓글수	<span class="pull-right"><?php echo number_format($menu[0]['count_comment']); ?> 개</span></li>
					<li><i class="fa fa-bug"></i> 전체 회원수	<span class="pull-right at-tip" data-original-title="<nobr>오늘 <?php echo $stats['join_today'];?> 명 / 어제 <?php echo $stats['join_yesterday'];?> 명</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><?php echo number_format($stats['join_total']); ?> 명</span>
					</li>
				</ul>
			</div>
			<!-- 통계 끝 -->

			<!-- SNS아이콘 시작 -->
			<div class="widget-box text-center">
				<?php echo $sns_share_icon; // SNS 공유아이콘 ?>
			</div>
			<!-- SNS아이콘 끝 -->

		</div>
	</div>
</div>
