<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$view_skin_url.'/view.css" media="screen">', 0);

$attach_list = '';
if ($view['link']) {
	// 링크
	for ($i=1; $i<=count($view['link']); $i++) {
		if ($view['link'][$i]) {
			$attach_list .= '<a class="list-group-item break-word" href="'.$view['link_href'][$i].'" target="_blank">';
			$attach_list .= '<i class="fa fa-link"></i> '.cut_str($view['link'][$i], 70).' &nbsp;<span class="blue">+ '.$view['link_hit'][$i].'</span></a>'.PHP_EOL;
		}
	}
}

// 가변 파일
$j = 0;
if ($view['file']['count']) {
	for ($i=0; $i<count($view['file']); $i++) {
		if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
			if ($board['bo_download_point'] < 0 && $j == 0) {
				$attach_list .= '<a class="list-group-item"><i class="fa fa-bell red"></i> 다운로드시 <b>'.number_format(abs($board['bo_download_point'])).'</b>'.AS_MP.' 차감 (최초 1회 / 재다운로드시 차감없음)</a>'.PHP_EOL;
			}
			$file_tooltip = '';
			if($view['file'][$i]['content']) {
				$file_tooltip = ' data-original-title="'.strip_tags($view['file'][$i]['content']).'" data-toggle="tooltip"';
			}
			$attach_list .= '<a class="list-group-item break-word view_file_download at-tip" href="'.$view['file'][$i]['href'].'"'.$file_tooltip.'>';
			$attach_list .= '<span class="pull-right hidden-xs text-muted"><i class="fa fa-clock-o"></i> '.date("Y.m.d H:i", strtotime($view['file'][$i]['datetime'])).'</span>';
			$attach_list .= '<i class="fa fa-download"></i> '.$view['file'][$i]['source'].' ('.$view['file'][$i]['size'].') &nbsp;<span class="orangered">+ '.$view['file'][$i]['download'].'</span></a>'.PHP_EOL;
			$j++;
		}
	}
}

$view_font = (G5_IS_MOBILE) ? '' : ' font-12';
$view_subject = get_text($view['wr_subject']);

?>

<?php 
	$week_w = array('일','월','화','수','목','금','토');
	$wr_date = date('Y년 m월 d일 ('.$week_w[date("w")].') H:i', $view['date'])
?>



<section itemscope itemtype="http://schema.org/NewsArticle" class="i_board_view please">

	<div class="i_board_header">
		<b class="board_header_subtit">개인</b>
		<span>해주세요</span>
	</div>


	<div class="i_board_content">
		<div class="board_content_detail">
			<b>해주세요 상세보기</b>
			
			<span class="content_date" itemprop="datePublished" content="<?php echo $wr_date;?>">
				등록일: <?php echo $wr_date; ?>
				<!-- <?php echo apms_date($wr_date, 'orangered', 'before'); //시간 ?> -->
			</span>
		</div>
	</div>


	<article itemprop="articleBody" class="i_board_content">
		<h1 itemprop="headline" content="<?php echo $view_subject;?>" class="content_title">
			<?php if($view['photo']) { ?><span class="talker-photo hidden-xs"><?php echo $view['photo'];?></span><?php } ?>
			<?php echo cut_str(get_text($view['wr_subject']), 70); ?>
		</h1>

		<div class="panel panel-default view-head<?php echo ($attach_list) ? '' : ' no-attach';?>">
			<div class="panel-heading content_body">

				<!-- 첨부파일 이미지 중 첫번째 사진만 불러와 썸네일로 사용합니다. -->
				<div class="content_body_thumnail">
					<?php echo get_view_thumbnail($view['file'][0]['view']) ?>
				</div>
				
				<!-- 여분필드 출력 시작 -->
				<div class="extra_fields">

					<p>
						<span itemprop="publisher" content="<?php echo get_text($view['wr_name']);?>">
							<?php echo $view['name']; //등록자 ?>
						</span>
						<?php echo ($is_ip_view) ? '<span class="print-hide hidden-xs">('.$ip.')</span>' : ''; ?>

						<button type="button" class="user_info_btn">유저정보</button>
					</p>


					<!-- 모든/지정 분류 · 지정 크리에이터 이름 시작 -->
					<p>
						<span>
							<?php echo $view['wr_2'] ? $view['wr_2'] : '카테고리를 출력 할 수 없습니다.' ?>
						</span>
						<span>
							<?php echo $view['wr_3'] ?><?php echo $view['wr_4'] === '' ?  '' : ' · '.$view['wr_4'] ?>
						</span>
						<span>
							<?php echo $view['wr_5'] ? $view['wr_5'] : '플랫폼 정보를 출력 할 수 없습니다.' ?>
						</span>
					</p>
					<!-- 모든/지정 분류 · 지정 크리에이터 이름 끝 -->

					<p>
						<span>기간</span>
						<span>2019.12.26 - 2020.02.26</span>
					</p>

					<p>
						<span>아몬드볼</span>
						<span><?php echo $view['wr_1'] ? $view['wr_1'] : '아몬드 정보를 출력 할 수 없습니다.' ?></span>
						<span>ABOLL</span>
					</p>

				</div>
				<!-- 여분필드 출력 끝 -->

				<div class="ellipsis text-muted<?php echo $view_font;?> content_body_info" style="display:none">
					<span itemprop="publisher" content="<?php echo get_text($view['wr_name']);?>">
						<?php echo $view['name']; //등록자 ?>
					</span>
					<?php echo ($is_ip_view) ? '<span class="print-hide hidden-xs">('.$ip.')</span>' : ''; ?>
					<?php if($view['ca_name']) { ?>
						<span class="hidden-xs">
							<span class="sp"></span>
							<i class="fa fa-tag"></i>
							<?php echo $view['ca_name']; //분류 ?>
						</span>
					<?php } ?>
					<span class="sp"></span>
					<i class="fa fa-comment"></i>
					<?php echo ($view['wr_comment']) ? '<b class="red">'.$view['wr_comment'].'</b>' : 0; //댓글수 ?>
					<span class="sp"></span>
					<i class="fa fa-eye"></i>
					<?php echo $view['wr_hit']; //조회수 ?>

					<?php if($is_good) { ?>
						<span class="sp"></span>
						<i class="fa fa-thumbs-up"></i>
						<?php echo $view['wr_good']; //추천수 ?>
					<?php } ?>
					<?php if($is_nogood) { ?>
						<span class="sp"></span>
						<i class="fa fa-thumbs-down"></i>
						<?php echo $view['wr_nogood']; //비추천수 ?>
					<?php } ?>
					<!-- <span class="pull-right">
						<i class="fa fa-clock-o"></i>
						<span itemprop="datePublished" content="<?php echo date('Y-m-dTH:i:s', $view['date']);?>">
							<?php echo apms_date($view['date'], 'orangered', 'before'); //시간 ?>
						</span>
					</span> -->
				</div>
			</div>
		   <?php
				if($attach_list) {
					echo '<div class="list-group'.$view_font.'">'.$attach_list.'</div>'.PHP_EOL;
				}
			?>
		</div>


		<div class="view-padding">

			<?php if ($is_torrent) echo apms_addon('torrent-basic'); // 토렌트 파일정보 ?>

			<?php

				// 이미지 상단 출력
				// i=1 부터 반복하여 첫번째 첨부파일을 제외한 나머지 사진을 출력합니다.
				$v_img_count = count($view['file']);
				if($v_img_count && $is_img_head) {
					echo '<div class="view-img">'.PHP_EOL;
					for ($i=1; $i<=count($view['file']); $i++) {
						if ($view['file'][$i]['view']) {
							echo get_view_thumbnail($view['file'][$i]['view']);
						}
					}
					echo '</div>'.PHP_EOL;
				}
			 ?>

			<div itemprop="description" class="view-content">
				<?php echo get_view_thumbnail($view['content']); ?>
			</div>

			<?php
				// 이미지 하단 출력
				if($v_img_count && $is_img_tail) {
					echo '<div class="view-img">'.PHP_EOL;
					for ($i=0; $i<=count($view['file']); $i++) {
						if ($view['file'][$i]['view']) {
							echo get_view_thumbnail($view['file'][$i]['view']);
						}
					}
					echo '</div>'.PHP_EOL;
				}
			?>
		</div>

		<?php if ($good_href || $nogood_href) { ?>
			<div class="print-hide view-good-box">
				<?php if ($good_href) { ?>
					<span class="view-good">
						<a href="#" onclick="apms_good('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'good', 'wr_good'); return false;">
							<b id="wr_good"><?php echo $view['wr_good']; ?></b>
							<br>
							<i class="fa fa-thumbs-up"></i>
						</a>
					</span>
				<?php } ?>
				<?php if ($nogood_href) { ?>
					<span class="view-nogood">
						<a href="#" onclick="apms_good('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'nogood', 'wr_nogood'); return false;">
							<b id="wr_nogood"><?php echo $view['wr_nogood']; ?></b>
							<br>
							<i class="fa fa-thumbs-down"></i>
						</a>
					</span>
				<?php } ?>
			</div>
			<p></p>
		<?php } else { //여백주기 ?>
			<div class="h40"></div>
		<?php } ?>

		<?php if ($is_tag) { // 태그 ?>
			<p class="view-tag view-padding<?php echo $view_font;?>"><i class="fa fa-tags"></i> <?php echo $tag_list;?></p>
		<?php } ?>

		<div class="print-hide view-icon view-padding">
			<?php 
				// SNS 보내기
				if ($board['bo_use_sns']) {
					echo apms_sns_share_icon('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $view['subject'], $seometa['img']['src']);
				}
			?>
			<span class="pull-right">
				<img src="<?php echo G5_IMG_URL;?>/sns/print.png" alt="프린트" class="cursor at-tip" onclick="apms_print();" data-original-title="프린트" data-toggle="tooltip">
				<?php if ($scrap_href) { ?>
					<img src="<?php echo G5_IMG_URL;?>/sns/scrap.png" alt="스크랩" class="cursor at-tip" onclick="win_scrap('<?php echo $scrap_href;  ?>');" data-original-title="스크랩" data-toggle="tooltip">
				<?php } ?>
				<?php if ($is_shingo) { ?>
					<img src="<?php echo G5_IMG_URL;?>/sns/shingo.png" alt="신고" class="cursor at-tip" onclick="apms_shingo('<?php echo $bo_table;?>', '<?php echo $wr_id;?>');" data-original-title="신고" data-toggle="tooltip">
				<?php } ?>
				<?php if ($is_admin) { ?>
					<?php if ($view['is_lock']) { // 글이 잠긴상태이면 ?>
						<img src="<?php echo G5_IMG_URL;?>/sns/unlock.png" alt="해제" class="cursor at-tip" onclick="apms_shingo('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'unlock');" data-original-title="해제" data-toggle="tooltip">
					<?php } else { ?>
						<img src="<?php echo G5_IMG_URL;?>/sns/lock.png" alt="잠금" class="cursor at-tip" onclick="apms_shingo('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'lock');" data-original-title="잠금" data-toggle="tooltip">
					<?php } ?>
				<?php } ?>
			</span>
			<div class="clearfix"></div>
		</div>

		<?php if($is_signature) { // 서명 ?>
			<div class="print-hide">
				<?php echo apms_addon('sign-basic'); // 회원서명 ?>
			</div>
		<?php } else { ?>
			<div class="view-author-none"></div>
		<?php } ?>

	</article>


</section>

<?php include_once('./view_comment.php'); ?>
