<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 링크
$is_modal_js = $wset['modal_js'];
$is_link_target = ($wset['modal'] == "2") ? ' target="_blank"' : '';

// 추출하기
if(!$wset['rows']) {
	$wset['rows'] = 12;	
}

// 추출하기
$wset['image'] = 1; //이미지글만 추출
$list = apms_board_rows($wset);
$list_cnt = count($list); // 글수

// 랭킹
$rank = apms_rank_offset($wset['rows'], $wset['page']);

// 날짜
$is_date = (isset($wset['date']) && $wset['date']) ? true : false;
$is_dtype = (isset($wset['dtype']) && $wset['dtype']) ? $wset['dtype'] : 'm.d';
$is_dtxt = (isset($wset['dtxt']) && $wset['dtxt']) ? true : false;

// 새글
$is_new = (isset($wset['new']) && $wset['new']) ? $wset['new'] : 'red'; 

// 분류
$is_cate = (isset($wset['cate']) && $wset['cate']) ? true : false;

// 글내용 - 줄이 1줄보다 크고
$is_cont = ($wset['line'] > 1) ? true : false; 
$is_details = ($is_cont) ? '' : ' no-margin'; 

// 동영상아이콘
$is_vicon = (isset($wset['vicon']) && $wset['vicon']) ? '' : '<i class="fa fa-play-circle-o post-vicon"></i>'; 

// 스타일
$is_center = (isset($wset['center']) && $wset['center']) ? ' text-center' : ''; 
$is_bold = (isset($wset['bold']) && $wset['bold']) ? true : false; 

// 그림자
$shadow_in = '';
$shadow_out = (isset($wset['shadow']) && $wset['shadow']) ? apms_shadow($wset['shadow']) : '';
if($shadow_out && isset($wset['inshadow']) && $wset['inshadow']) {
	$shadow_in = '<div class="in-shadow">'.$shadow_out.'</div>';
	$shadow_out = '';	
}

// 리스트
for ($i=0; $i < $list_cnt; $i++) {

	//아이콘 체크
	$wr_icon = '';
	$is_lock = false;
	if ($list[$i]['secret'] || $list[$i]['is_lock']) {
		$is_lock = true;
		$wr_icon = '<span class="rank-icon en bg-orange en">Lock</span>';	
	} else if ($wset['rank']) {
		$wr_icon = '<span class="rank-icon en bg-'.$wset['rank'].'">'.$rank.'</span>';	
		$rank++;
	} else if($list[$i]['new']) {
		$wr_icon = '<span class="rank-icon txt-normal en bg-'.$is_new.'">New</span>';	
	}

	// 링크이동
	$target = '';
	if($is_link_target && $list[$i]['wr_link1']) {
		$target = $is_link_target;
		$list[$i]['href'] = $list[$i]['link_href'][1];
	}

	//볼드체
	if($is_bold) {
		$list[$i]['subject'] = '<b>'.$list[$i]['subject'].'</b>';
	}

?>
	<div class="post-row">
		<div class="post-list">
			<div class="post-image">
				<a href="<?php echo $list[$i]['href'];?>" class="ellipsis"<?php echo $is_modal_js;?><?php echo $target;?>>
					<div class="img-wrap">
						<?php echo $shadow_in;?>
						<?php if($list[$i]['as_list'] == "2" || $list[$i]['as_list'] == "3") echo $is_vicon; ?>
						<div class="img-item">
							<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
						</div>
					</div>
				</a>
				<?php echo $shadow_out;?>
			</div>

			<!-- 커스텀 여분필드에 사용될 변수 -->
			<?php
				$platform = ''; // 플랫폼 class 변수
				switch ($list[$i]['wr_5']) {
					case '카카오TV':
						$platform = 'kakao';
					break;

					case '유튜브':
						$platform = 'youtube';
					break;

					case '트위치':
						$platform = 'twitch';
					break;

					default:
						$platform = '';
				}
			?>

				<!-- 커스텀 여분필드 시작 -->
				<div class="extra_fields please">
					<div class="item_category">
						<span><?php echo $list[$i]['wr_2'] ?></span> <!-- 방송분류 -->
						<span><?php echo $list[$i]['wr_3'] ?><?php echo $list[$i]['wr_4'] === '' ?  '' : ' · '.$list[$i]['wr_4'] ?></span> <!-- 모든/지정 분류 · 지정 크리에이터 이름 -->
						<span class="platform <?php echo $platform ?>"><?php echo $list[$i]['wr_5'] ?></span> <!-- 플랫폼 -->
					</div>

					<div class="item_title">
						<a href="<?php echo $list[$i]['href'];?>"<?php echo $is_modal_js;?><?php echo $target;?>>
							<?php /*echo $wr_icon;*/ ?> <?php echo $list[$i]['subject'];?>
						</a>
					</div>
					
					<?php if($is_cont) { ?>
						<div class="item_desc">
							<a href="<?php echo $list[$i]['href'];?>"<?php echo $is_modal_js;?><?php echo $target;?>>
								<?php echo apms_cut_text($list[$i]['content'], 55);?>
							</a>
						</div>
					<?php } ?>

					<div class="item_writer">
						<?php echo $list[$i]['name'];?>
					</div>

					<div class="item_status">
							<span class="s_comment">
								<i class="fa fa-comment" aria-hidden="true"></i> <em><?php echo $list[$i]['comment']; ?></em>
							</span>
							<span class="s_like">
								<i class="fa fa-thumbs-up" aria-hidden="true"></i> <em><?php echo $list[$i]['wr_good']; ?></em>
							</span>
							<span class="s_interest">
								<i class="fa fa-eye" aria-hidden="true"></i> <?php echo $list[$i]['wr_hit']; ?>
							</span>
							<span class="s_amond">
								<i class="icon-a-ball" aria-hidden="true"></i> <?php echo $list[$i]['wr_1']; ?>
							</span>
							<a class="s_more_btn" href="<?php echo $list[$i]['href'];?>">More</a>
					</div>
				</div>
				<!-- 커스텀 여분필드 끝 -->

		</div>
	</div>
<?php } // end for ?>
<?php if(!$list_cnt) { ?>
	<div class="post-none">등록된 글이 없습니다.</div>
<?php } ?>
