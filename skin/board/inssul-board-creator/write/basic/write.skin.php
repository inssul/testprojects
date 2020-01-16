<!-- <script src="/custom/js/write.js"></script> -->

<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$write_skin_url.'/write.css" media="screen">', 0);

if(!$header_skin) { 
?>
<!-- <div class="well">
	<h2><?php echo $g5['title'] ?></h2>
</div> -->

<?php } ?>


<!-- 게시물 작성/수정 시작 -->
<?php
    // 업데이트 게시판은 기존에서
    // $action_url 에서 새로 수정 생성함.
    $action_tem = $action_url;
    $action_url = '/bbs/write_update_please.php';

?>
<form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" role="form" class="form-horizontal">
<input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
<input type="hidden" name="sca" value="<?php echo $sca ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="spt" value="<?php echo $spt ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<?php
	$option = '';
	$option_hidden = '';
	if ($is_notice || $is_html || $is_secret || $is_mail) {
		if ($is_notice) {
			$option .= "\n".'<label class="f_cl sp-label"><input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'> 공지</label>';
		}

		if ($is_html) {
			if ($is_dhtml_editor) {
				$option_hidden .= '<input type="hidden" value="html1" name="html">';
			} else {
				$option .= "\n".'<label class="f_cl sp-label"><input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'> HTML</label>';
			}
		}

		if ($is_secret) {
			if ($is_admin || $is_secret==1) {
				$option .= "\n".'<label class="f_cl sp-label"><input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'> 비밀글</label>';
			} else {
				$option_hidden .= '<input type="hidden" name="secret" value="secret">';
			}
		}

		if ($is_notice) {
			$main_checked = ($write['as_type']) ? ' checked' : '';
			$option .= "\n".'<label class="f_cl sp-label"><input type="checkbox" id="as_type" name="as_type" value="1" '.$main_checked.'> 메인글</label>';
		}

		if ($is_mail) {
			$option .= "\n".'<label class="f_cl sp-label"><input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'> 답변메일받기</label>';
		}
	}

	echo $option_hidden;
?>



<?php if ($is_name) { ?>
	<div class="i_fg has-feedback">
		<label class="f_cl" for="wr_name">이름<strong class="sound_only">필수</strong></label>
		<div class="col-sm-3">
			<input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="form-control input-sm" size="10" maxlength="20">
			<span class="fa fa-check form-control-feedback"></span>
		</div>
	</div>
<?php } ?>

<?php if ($is_password) { ?>
	<div class="i_fg has-feedback">
		<label class="f_cl" for="wr_password">비밀번호<strong class="sound_only">필수</strong></label>
		<div class="col-sm-3">
			<input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="form-control input-sm" maxlength="20">
			<span class="fa fa-check form-control-feedback"></span>
		</div>
	</div>
<?php } ?>

<?php if ($is_email) { ?>
	<div class="i_fg">
		<label class="f_cl" for="wr_email">E-mail</label>
		<div class="col-sm-6">
			<input type="text" name="wr_email" id="wr_email" value="<?php echo $email ?>" class="form-control input-sm email" size="50" maxlength="100">
		</div>
	</div>
<?php } ?>

<?php if ($is_homepage) { ?>
	<div class="i_fg">
		<label class="f_cl" for="wr_homepage">홈페이지</label>
		<div class="col-sm-6">
			<input type="text" name="wr_homepage" id="wr_homepage" value="<?php echo $homepage ?>" class="form-control input-sm" size="50">
		</div>
	</div>
<?php } ?>

<div class="i_title">
	<h3>글쓰기</h3>
</div>


<?php if ($is_category || $option) { ?>
	<div class="i_fg ">
	<label class="f_cl hidden-xs">옵션</label>
	<?php if ($is_category) { ?>
			<div class="admin_option">
				<div class="h10 visible-xs"></div>
				<?php echo $option ?>
			</div>
		<?php } ?>
		</div>


	<!-- <div class="i_fg">
		<label class="f_cl hidden-xs"><?php echo ($is_category) ? '분류' : '옵션';?></label>

		<?php if ($option) { ?>
			<div class="f_ci">
				<select name="ca_name" id="ca_name" required class="form-control">
					<option value="">선택하세요</option>
					<?php echo $category_option ?>
				</select>
			</div>
		<?php } ?>

	</div> -->
<?php } ?>


<!-- 포토 시작 (임시 숨김처리) -->
<div class="i_fg" style="display: none;">
	<label class="f_cl hidden-xs">포토</label>
	<div class="">
		<input type="hidden" name="as_icon" value="<?php echo $write['as_icon'];?>" id="picon">
		<?php
			$fa_photo = (isset($boset['ficon']) && $boset['ficon']) ? apms_fa($boset['ficon']) : '<i class="fa fa-user"></i>';		
			$myicon = ($w == 'u') ? apms_photo_url($write['mb_id']) : apms_photo_url($member['mb_id']);
			$myicon = ($myicon) ? '<img src="'.$myicon.'">' : $fa_photo;
			if($write['as_icon']) {
				$as_icon = apms_fa(apms_emo($write['as_icon']));
				$as_icon = ($as_icon) ? $as_icon : $myicon;
			} else {
				$as_icon = $myicon;
			}
		?>
		<style>
			.write-wrap .talker-photo i { 
				<?php echo (isset($boset['ibg']) && $boset['ibg']) ? 'background:'.apms_color($boset['icolor']).'; color:#fff' : 'color:'.apms_color($boset['icolor']);?>; 
			}
		</style>
		<span id="ticon" class="talker-photo"><?php echo $as_icon;?></span>
		&nbsp;
		<div class="btn-group" data-toggle="buttons">
			<label class="btn btn-default" onclick="apms_emoticon('picon', 'ticon');" title="이모티콘">
				<input type="radio" name="select_icon" id="select_icon1">
				<i class="fa fa-smile-o fa-lg"></i><span class="sound_only">이모티콘</span>
			</label>
			<label class="btn btn-default" onclick="win_scrap('<?php echo G5_BBS_URL;?>/ficon.php?fid=picon&sid=ticon');" title="FA아이콘">
				<input type="radio" name="select_icon" id="select_icon2">
				<i class="fa fa-info-circle fa-lg"></i><span class="sound_only">FA아이콘</span>
			</label>
			<label class="btn btn-default" onclick="apms_myicon();" title="내사진">
				<input type="radio" name="select_icon" id="select_icon3">
				<i class="fa fa-user fa-lg"></i><span class="sound_only">내사진</span>
			</label>
		</div>
	</div>
</div>
<!-- 글쓰기 포토 -->




<!-- 제목 시작 -->
<div class="i_fg">
	<label class="f_cl" for="wr_subject">제목<strong class="sound_only">필수</strong></label>
	<div class="">
		<div class="input-group">
			<input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="form-control input-sm" size="50" maxlength="255">
			<span class="input-group-btn" role="group" style="display: none;">
				<a href="<?php echo G5_BBS_URL;?>/helper.php" target="_blank" class="btn btn-<?php echo $btn1;?> btn-sm hidden-xs win_scrap">안내</a>
				<a href="<?php echo G5_BBS_URL;?>/helper.php?act=map" target="_blank" class="btn btn-<?php echo $btn1;?> btn-sm hidden-xs win_scrap">지도</a>
				<?php if ($is_member) { // 임시 저장된 글 기능 ?>
					<button type="button" id="btn_autosave" data-toggle="modal" data-target="#autosaveModal" class="btn btn-<?php echo $btn1;?> btn-sm">저장 (<span id="autosave_count"><?php echo $autosave_count; ?></span>)</button>
				<?php } ?>
			</span>
		</div>
	</div>
</div>
<!-- 제목 끝 -->
<!-- 기간 필드 추가 시작 -->
<div class="i_fg">
	<label class="f_cl"><?php echo $board['bo_2_subj'] ?><strong class="sound_only">필수</strong></label>
	<div class="f_ci">
		<div class="input-group date">
			<div class="date_start">
				<!-- <input type="date" name="wr_term_start" class="form-control input-sm wr_term_start" id="wr_term_start" required/> -->
			</div>
			<div class="date_end">
				<input type="date" name="wr_2" value="<?php echo $write['wr_2'] ?>" class="form-control input-sm wr_term_end" id="wr_term_end" required class="form-control input-sm"/>
			</div>
		</div>
	</div>
</div>
<!-- 기간 필드 추가 끝 -->

<!-- 카테고리 필드 추가 시작 -->
<div class="i_fg">
	<label class="f_cl" for="wr_category"><?php echo $board['bo_3_subj'] ?><strong class="sound_only">필수</strong></label>
	<div class="f_ci">
		<div class="input-group">
		<select name="wr_3" id="wr_category" class="input-sm" style="border-radius:0">
			<?php
				$item_list = explode(',', $board['bo_3']);
				for ($i=0; $i<count($item_list); $i++) {
						$option_item = trim($item_list[$i]);
			?>
				<option value="<?php echo $option_item ?>"<?php echo ($write['wr_3'] == $option_item) ? " selected" : "";?>><?php echo $option_item ?></option>
			<?php } ?>
		</select>
		</div>
	</div>
</div>
<!-- 카테고리 필드 추가 끝 -->

<!-- 크리에이터 분류 필드 추가 시작 -->
<div class="i_fg">
	<label class="f_cl" for="wr_creator_target"><?php echo $board['bo_4_subj'] ?><strong class="sound_only">필수</strong></label>
	<div class="f_ci">
		<div class="input-group search_creator">
			<select name="wr_4" id="wr_creator_target" class="input-sm" style="border-radius:0">
				<?php
					$item_list = explode(',', $board['bo_4']);
					for ($i=0; $i<count($item_list); $i++) {
							$option_item = trim($item_list[$i]);
				?>
					<option value="<?php echo $option_item ?>"<?php echo ($write['wr_4'] == $option_item) ? " selected" : "";?>><?php echo $option_item ?></option>
				<?php } ?>
			</select>

			<div class="search_form">
				<input type="search" name="wr_5" id="wr_creator_search" placeholder="크리에이터를 검색해보세요" class="form-control input-sm">
				<i class="fa fa-search fa-lg"></i>
			</div>
		</div>
	</div>
</div>
<!-- 크리에이터 분류 추가 끝 -->

<!-- 플랫폼 필드 추가 시작 -->
<!-- <div class="i_fg">
	<label class="f_cl" for="wr_select_platform"><?php echo $board['bo_5_subj'] ?><strong class="sound_only">필수</strong></label>
	<div class="f_ci">
		<div class="input-group">
		<select name="wr_5" id="wr_select_platform" class="input-sm" style="border-radius:0">
			<?php
				$item_list = explode(',', $board['bo_5']);
				for ($i=0; $i<count($item_list); $i++) {
						$option_item = trim($item_list[$i]);
			?>
				<option value="<?php echo $option_item; ?>"<?php echo ($write['wr_5'] == $option_item) ? " selected" : "";?>><?php echo $option_item ?></option>
			<?php } ?>
		</select>
		</div>
	</div>
</div> -->
<!-- 플랫폼 필드 추가 끝 -->

<!-- 우선노출 필드 추가 시작 -->
<div class="i_fg">
	<label class="f_cl" for=""><?php echo $board['bo_6_subj']; ?></label>
	<div class="f_ci">
		<div class="input-group pay_post_group">
			<input type="hidden" name="wr_6" value="<?php echo $write['wr_6'] ?>" id="payPostValue">
			<button type="button" class="pay_post_btn active" value="1">
					<span><b>1</b>일</span>
					<span><b>10</b> ABOLL</span>
			</button>
			<button type="button" class="pay_post_btn " value="3">
					<span><b>3</b>일</span>
					<span><b>30</b> ABOLL</span>
			</button>
			<button type="button" class="pay_post_btn " value="7">
					<span><b>7</b>일</span>
					<span><b>60</b> ABOLL</span>
			</button>

			<select name="" id="pay_post_definition">
				<option>다른 기간 선택하기</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
			</select>

		</div>
	</div>
</div>
<!-- 우선노출 필드 추가 끝 -->

<!-- 아몬드볼 필드 추가 시작 -->
<div class="i_fg">
	<label class="f_cl" for="wr_aball"><?php echo $board['bo_1_subj'] ?><strong class="sound_only">필수</strong></label>
	<div class="f_ci">
		<div class="input-group aball_counter i_count_number" id="writeCounter">
			<input type="number" value="0" data-own-aball="<?php echo $member['mb_point']; ?>" name="wr_1" id="wr_aball" max="<?php echo $member['mb_point'];?>" min="0" required class="form-control input-sm" size="50" maxlength="255"> <span class="hold_points">※ 보유 아몬드볼 <b><?php echo $member['mb_point'];?></b> ABOLL</span>
			<button type="button" class="count_btn plus"></button>
			<button type="button" class="count_btn minus"></button>
		</div>
	</div>
</div>
<!-- 아몬드볼 필드 추가 끝 -->



<?php if ($is_member) { // 임시 저장된 글 기능 ?>
	<script src="<?php echo G5_JS_URL; ?>/autosave.js"></script>
	<?php if($editor_content_js) echo $editor_content_js; ?>
	<div class="modal fade" id="autosaveModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">임시 저장된 글 목록</h4>
				</div>
				<div class="modal-body">
					<div id="autosave_wrapper">
						<div id="autosave_pop">
							<ul></ul>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
<?php } ?>


<div class="i_fg">
<label class="f_cl">상세내용</label>
	<div class="f_ci text_editor">
		<?php if($write_min || $write_max) { ?>
			<!-- 최소/최대 글자 수 사용 시 -->
			<div class="well well-sm" style="margin-bottom:15px;">
				현재 <strong><span id="char_count"></span></strong> 글자이며, 최소 <strong><?php echo $write_min; ?></strong> 글자 이상, 최대 <strong><?php echo $write_max; ?></strong> 글자 이하까지 쓰실 수 있습니다.
			</div>
		<?php } ?>
		<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
	</div>
</div>

<div class="i_fg ">
	<label class="f_cl" for="">상세조건</label>
	<div class="f_ci detail_conditions">
		
			<div class="i_fg">
				<label class="f_cl" for="condition_concept"><?php echo $board['bo_8_subj']; ?></label>
				<div class="f_ci condition_area">
					<textarea type="text" name="wr_8" id="condition_concept" value="" class="form-control"><?php echo $write['wr_8']; ?></textarea>
				</div>
			</div>

			<div class="i_fg">
				<label class="f_cl" for="condition_storyboard"><?php echo $board['bo_9_subj']; ?></label>
				<div class="f_ci condition_area">
					<textarea type="text" name="wr_9" id="condition_storyboard" value="" class="form-control"><?php echo $write['wr_9']; ?></textarea>
				</div>
			</div>

			<div class="i_fg">
				<label class="f_cl" for="condition_list"><?php echo $board['bo_10_subj']; ?></label>
				<div class="f_ci condition_area">
					<textarea type="text" name="wr_10" id="condition_list" value="" class="form-control"><?php echo $write['wr_10']; ?></textarea>
				</div>
			</div>

		<?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
			<div class="i_fg">
				<label class="f_cl" for="wr_link<?php echo $i ?>">참고링크<?php echo $i ?></label>
				<div class="f_ci condition_link">
					<input type="url" name="wr_link<?php echo $i ?>" value="<?php echo $write['wr_link'.$i]; ?>" id="wr_link<?php echo $i ?>" class="form-control input-sm" size="50">
					<?php if($i == "1") { ?>
						<!-- <div class="text-muted font-12" style="margin-top:4px;">
							유튜브, 비메오 등 동영상 공유주소 등록시 해당 동영상은 본문 자동실행
						</div> -->
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>
</div>


<?php if ($is_file) { ?>
	<div class="i_fg write_uploader">
		<label class="f_cl" id="write_upload_preview" for="write_upload">
			<button type="button" class="cancel_img_btn"><i class="icon-cancel-circle"></i></button>
		</label>
		<input type="file" id="write_upload" name="bf_file[]" multiple accept="image/*" />
		<table id="variableFiles" style="display: none;"></table>
	</div>

	<!-- <script>
	var flen = 0;
	function add_file(delete_code) {
		var upload_count = <?php echo (int)$board['bo_upload_count']; ?>;
		if (upload_count && flen >= upload_count) {
			alert("이 게시판은 "+upload_count+"개 까지만 파일 업로드가 가능합니다.");
			return;
		}

		var objTbl;
		var objNum;
		var objRow;
		var objCell;
		var objContent;
		if (document.getElementById)
			objTbl = document.getElementById("variableFiles");
		else
			objTbl = document.all["variableFiles"];

		objNum = objTbl.rows.length;
		objRow = objTbl.insertRow(objNum);
		objCell = objRow.insertCell(0);

		objContent = "<div class='row'>";
		objContent += "<div class='col-sm-7'><div class='i_fg'><div class='input-group input-group-sm'><span class='input-group-addon'>파일 "+objNum+"</span><input type='file' class='form-control input-sm' name='bf_file[]' title='파일 용량 <?php echo $upload_max_filesize; ?> 이하만 업로드 가능'></div></div></div>";
		if (delete_code) {
			objContent += delete_code;
		} else {
			<?php if ($is_file_content) { ?>
			objContent += "<div class='col-sm-5'><div class='i_fg'><input type='text'name='bf_content[]' class='form-control input-sm' placeholder='이미지에 대한 내용을 입력하세요.'></div></div>";
			<?php } ?>
			;
		}
		objContent += "</div>";

		objCell.innerHTML = objContent;

		flen++;
	}

	<?php echo $file_script; //수정시에 필요한 스크립트?>

	function del_file() {
		// file_length 이하로는 필드가 삭제되지 않아야 합니다.
		var file_length = <?php echo (int)$file_length; ?>;
		var objTbl = document.getElementById("variableFiles");
		if (objTbl.rows.length - 1 > file_length) {
			objTbl.deleteRow(objTbl.rows.length - 1);
			flen--;
		}
	}
	</script> -->

	<!-- <div class="i_fg">
		<label class="f_cl">첨부사진</label>
		<div class="">
			<label class="f_cl sp-label">
				<input type="radio" name="as_img" value="0"<?php if(!$write['as_img']) echo ' checked';?>> 상단출력
			</label>
			<label class="f_cl sp-label">
				<input type="radio" name="as_img" value="1"<?php if($write['as_img'] == "1") echo ' checked';?>> 하단출력
			</label>
			<label class="f_cl sp-label">
				<input type="radio" name="as_img" value="2"<?php if($write['as_img'] == "2") echo ' checked';?>> 본문삽입
			</label>
			<div class="text-muted font-12" style="margin-top:4px;">
				본문삽입시 {이미지:0}, {이미지:1} 형태로 글내용 입력시 지정 첨부사진이 출력됨
			</div>
		</div>
	</div>
<?php } ?> -->

<?php if ($captcha_html) { //자동등록방지  ?>
	<div class="well well-sm text-center">
		<?php echo $captcha_html; ?>
	</div>
<?php } ?>

<ul class="write_notice">
	<li>※ 컨텐츠가 완료되었을 경우 채택기간은 일주일(7일) 안에 채택을 완료 해주셔야 합니다.</li>
	<li>※ 기간완료 후 채택을 하지 않을경우 답변자에게 아몬드볼이 자동 지급됩니다. [답변자가 많을 경우 답변자 수에 따른 아몬드볼 배분]</li>
	<li>※ 답변 컨텐츠가 맘에들지 않을 경우 채택기간(7일) 안에 답변자에게 수정을 요구할 수 있습니다.<br>[수정이 완료되지 않았을경우, 조건에 맞지 않을경우 미채택 버튼을 누르면 관리자 검토후 결정됩니다. ]</li>
	<li>- 올바르지 않을 경우 작성자 에게 아몬드볼의 60%만 환급됩니다.</li>
	<li>- 올바를 경우 답변자에게 아몬드볼 100%가 지급됩니다.</li>
	<li><br>※ 채택완료 후 발생되는 거래당사자 간으ㅣ분쟁은 인썰에서 조정하지 않으며, 작성자가 직접 외부 중재 제기를 하시기 바랍니다. </li>
</ul>

<div class="write-btn pull-center">
	<a href="./board.php?bo_table=<?php echo $bo_table ?>" class="wrtie_cancel_btn" role="button">취소</a>
	<button type="submit" id="btn_submit" accesskey="s" class="write_up_btn">올리기</button>
</div>

<div class="clearfix"></div>

</form>

<script>
  const writePage = new WriterPage()

</script>

<script>
<?php if($write_min || $write_max) { ?>
// 글자수 제한
var char_min = parseInt(<?php echo $write_min; ?>); // 최소
var char_max = parseInt(<?php echo $write_max; ?>); // 최대
check_byte("wr_content", "char_count");

$(function() {
	$("#wr_content").on("keyup", function() {
		check_byte("wr_content", "char_count");
	});
});
<?php } ?>

function apms_myicon() {
	document.getElementById("picon").value = '';
	document.getElementById("ticon").innerHTML = '<?php echo str_replace("'","\"", $myicon);?>';
	return true;
}

function html_auto_br(obj) {
	if (obj.checked) {
		result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
		if (result)
			obj.value = "html2";
		else
			obj.value = "html1";
	}
	else
		obj.value = "";
}

function fwrite_submit(f) {

	<?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

	var subject = "";
	var content = "";
	$.ajax({
		url: g5_bbs_url+"/ajax.filter.php",
		type: "POST",
		data: {
			"subject": f.wr_subject.value,
			"content": f.wr_content.value
		},
		dataType: "json",
		async: false,
		cache: false,
		success: function(data, textStatus) {
			subject = data.subject;
			content = data.content;
		}
	});

	if (subject) {
		alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
		f.wr_subject.focus();
		return false;
	}

	if (content) {
		alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
		if (typeof(ed_wr_content) != "undefined")
			ed_wr_content.returnFalse();
		else
			f.wr_content.focus();
		return false;
	}

	if (document.getElementById("char_count")) {
		if (char_min > 0 || char_max > 0) {
			var cnt = parseInt(check_byte("wr_content", "char_count"));
			if (char_min > 0 && char_min > cnt) {
				alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
				return false;
			}
			else if (char_max > 0 && char_max < cnt) {
				alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
				return false;
			}
		}
	}

	<?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

	document.getElementById("btn_submit").disabled = "disabled";

	return true;
}

$(function(){
	$("#wr_content").addClass("form-control input-sm write-content");
});
</script>



<script>

	const writeFileUploader = new FileUpload({
			selector: '#write_upload',
			preview: '#write_upload_preview'
	})

	const writeCounter = new Counter({ selector: '#writeCounter' })

	document.querySelector('#write_upload_preview .cancel_img_btn').addEventListener('click', (e) => {
		if (e.currentTarget.nextElementSibling) {
			document.querySelector('#write_upload').value = null
			e.currentTarget.nextElementSibling.remove()
			e.currentTarget.parentElement.classList.remove('comment_hide')
		}
	})

	const categorySelector = document.querySelector('#wr_creator_target')
	const categorySearch = document.querySelector('#wr_creator_search')

	function toggleSearch(selector) {
		const type = selector.value

		if (type === '지정 크리에이터') {
			categorySearch.parentNode.style.display = ''
		} else {
			categorySearch.value = ''
			categorySearch.parentNode.style.display = 'none'
		}
	}

	toggleSearch(categorySelector)

	categorySelector.addEventListener('change', () => {
		toggleSearch(categorySelector)
	})



</script>