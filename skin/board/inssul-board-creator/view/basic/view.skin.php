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
	$wr_date = date('Y년 m월 d일 ('.$week_w[date("w")].') H:i', $view['date']);

		// 분류 사용 여부
	$is_category = false;
	$category_option = '';
	if ($board['bo_use_category']) {
			$is_category = true;
			$category_href = G5_BBS_URL.'/board.php?bo_table='.$bo_table;

			$category_option .= '<li><a href="'.$category_href.'"';
			if ($sca=='')
					$category_option .= ' id="bo_cate_on"';
			$category_option .= '>전체</a></li>';

			$categories = explode('|', $board['bo_category_list']); // 구분자가 , 로 되어 있음
			for ($i=0; $i<count($categories); $i++) {
					$category = trim($categories[$i]);
					if ($category=='') continue;
					$category_option .= '<li><a href="'.($category_href."&amp;sca=".urlencode($category)).'"';
					$category_msg = '';
					if ($category==$sca) { // 현재 선택된 카테고리라면
							$category_option .= ' id="bo_cate_on"';
							$category_msg = '<span class="sound_only">열린 분류 </span>';
					}
					$category_option .= '>'.$category_msg.$category.'</a></li>';
			}
	}
?>


<!-- 카테고리 시작 -->
<?php
if($is_category)
    include_once($board_skin_path.'/category.skin.php'); 
?>
<!-- 카테고리 끝 -->

<section itemscope itemtype="http://schema.org/NewsArticle" class="i_board_view please">
<!-- 
	<div class="i_board_header">
		<b class="board_header_subtit">개인</b>
		<span>해주세요</span>
	</div> -->


	<div class="i_board_content">
		<div class="board_content_detail">
			<b>해주세요 상세보기</b>
			
			<span class="content_date" itemprop="datePublished" content="<?php echo $wr_date;?>">
				등록일: <?php echo $wr_date; ?>
				<!-- <?php echo apms_date($wr_date, 'orangered', 'before'); //시간 ?> -->
			</span>

			<?php 
				// SNS 보내기
				if ($board['bo_use_sns']) {
					echo apms_sns_share_icon('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $view['subject'], $seometa['img']['src']);
				}
			?>

			<div class="optional_btns">
				<button class="print_btn i_btn cursor at-tip" alt="프린트" type="button" data-original-title="프린트" data-toggle="tooltip" onclick="apms_print();"><i class="fa fa-print" aria-hidden="true"></i> <span>인쇄하기</span></button>
				<?php if ($scrap_href) { ?>
					<button class="scrap_btn i_btn cursor at-tip" alt="스크랩" type="button" onclick="win_scrap('<?php echo $scrap_href;  ?>');" data-original-title="스크랩" data-toggle="tooltip" onclick="apms_print();"><i class="fa fa-star-o" aria-hidden="true"></i> <span>스크랩</span></button>
				<?php } ?>
				<?php if ($is_shingo) { ?>
					<button class="shingo_btn i_btn cursor at-tip" alt="신고" type="button"onclick="apms_shingo('<?php echo $bo_table;?>', '<?php echo $wr_id;?>');" data-original-title="신고" data-toggle="tooltip"><i class="fa fa-ban" aria-hidden="true"></i> <span>허위정보 신고</span></button>
				<?php } ?>
				<?php if ($is_admin) { ?>
					<?php if ($view['is_lock']) { // 글이 잠긴상태이면 ?>
						<button class="unlock_btn i_btn cursor at-tip" alt="잠금해제" type="button"  onclick="apms_shingo('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'unlock');" data-original-title="해제" data-toggle="tooltip"><i class="fa fa-unlock" aria-hidden="true"></i> <span>잠금해제</span></button>
					<?php } else { ?>
						<button class="lock_btn i_btn cursor at-tip" alt="잠금" type="button"  onclick="apms_shingo('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'lock');" data-original-title="잠금" data-toggle="tooltip"><i class="fa fa-lock" aria-hidden="true"></i> <span>잠금</span></button>
					<?php } ?>
				<?php } ?>
			</div>


			<div class="clearfix"></div>
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
				<div class="extra_fields write">
					<p>
						<span class="profile_img">
							img
						</span>
						<span class="profile_name" itemprop="publisher" content="<?php echo get_text($view['wr_name']);?>">
							<?php echo $view['name']; //등록자 ?>
						</span>

						<button type="button" class="user_info_btn">유저정보</button>
					</p>

					
					<!-- 모든/지정 분류 · 지정 크리에이터 이름 시작 -->
					<p>
						<span>
							<?php echo $view['wr_3']; ?><?php echo $view['wr_4'] === '' ?  '' : ' | '.$view['wr_4']. ' | ' ?>
						</span>
						<span>
							<?php echo $view['wr_5']; ?>
						</span>
					</p>
					<!-- 모든/지정 분류 · 지정 크리에이터 이름 끝 -->

					<!-- 마감날짜 시작 -->
					<p class="content_body_term">
						<span>
							기간
						</span>
						<span>
							<?php echo $view['wr_2']; ?>
						</span>
					</p>
					<!-- 마감날짜 끝 -->

					<!-- 아몬드볼 시작 -->
					<p class="content_body_aball">
						<span>아몬드볼</span>
						<span><b><?php echo $view['wr_1']; ?></b></span>
						<span><b>ABOLL</b></span>
						<button type="button">아몬드볼 얹기</button>
					</p>
					<!-- 아몬드볼 끝 -->

					<div class="info">
						<p>
							<span>아몬드볼</span>
							<span>총 190 ABOLL</span>
						</p>
						<p>
							<span>추가 참여자</span>
							<span>15 명</span>
						</p>
						<p>
							진행중
						</p>

						<div class="popular">
							<i class="fa fa-eye"></i> <?php echo $view['wr_hit']; ?>															
							<i class="fa fa-thumbs-up"></i> <?php echo $view['wr_good']; ?>							
							<i class="fa fa-thumbs-down"></i> <?php echo $view['wr_nogood']; ?>
						</div>
					</div>

					<p class="comment">
						<i class="fa fa-commenting" aria-hidden="true"></i> 부적절하고 폭력적, 불쾌감을 주는 내용일 경우 법적 처벌을 받을 수 있습니다.
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

		<div class="content_sns">
			더 많은 참여를 위해 SNS 등에 페이지를 공유하는 것이 도움이 됩니다.

			<button type="button" class="facebook"></button>
			<button type="button" class="naver"></button>
			<button type="button" class="kakao"></button>
			<button type="button" class="twitch"></button>
		</div>

		<div class="">

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
				<h4>상세내용</h4>
				<?php echo get_view_thumbnail($view['content']); ?>
			</div>

			<!-- 상세조건 시작 -->
			<div class="view-content view_detail_condition">
				<h4 class=" border-none">상세조건</h4>
				<p>
					- 컨셉: <?php echo $view['wr_8']; ?>
				</p>
				<p>
					- 스토리보드: <?php echo $view['wr_9']; ?>
				</p>
				<p>
					- 조건: <?php echo $view['wr_10']; ?>
				</p>
			</div>
			<!-- 상세조건 끝 -->

			<div class="view_detail_join">
				<button type="button">답변참여</button>
				<a href="#" class="participants_list_btn">참여자명단</a>
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



		<?php if($is_signature) { // 서명 ?>
			<div class="print-hide">
				<?php echo apms_addon('sign-basic'); // 회원서명 ?>
			</div>
		<?php } else { ?>
			<div class="view-author-none"></div>
		<?php } ?>

	</article>

	<article class="contents_upload">
		<button type="button" id="contents_upload_btn">컨텐츠 올리기</button>
	</article>

	<article class="view_comment_wrap">
		<?php include_once('./view_comment.php'); ?>
	</article>


</section>


<script>
		(() => {
			// 썸네일 없을 시 대체 이미지 삽입
			const thumbnail = document.querySelector('.content_body_thumnail')
			if (!thumbnail.children.length) {
				thumbnail.innerHTML = `<img src="/custom/images/thumb-no-img_202x150.jpg" style="width: 100%;" />`
			}
		})()
</script>