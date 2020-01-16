<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if ($is_admin != 'super') {
    alert('관리자 전용 메뉴입니다.', '/');
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

$sql = " SELECT * FROM g5_creators , {$g5['member_table']} where ct_id = $ct_no ";
$row = sql_fetch($sql);

$reject_rason = $row[$platform.'_reject_reason'];

$extra_files =  extra_files($mb_id, $platform);

function extra_files( $mb_id='', $url='' ) {
    $files_array = array();
    global $xp;
    if(!$mb_id) return $xp['xp_photo_url'];
    $mb_dir = substr($mb_id,0,2);
    for ( $i = 0; $i < 10; $i++ ) {
        $photo_url = G5_DATA_URL.'/creator/'.$mb_dir.'/'.$mb_id.'_'.$url.'_'.$i.'.gif';
        $photo_file = G5_DATA_PATH.'/creator/'.$mb_dir.'/'.$mb_id.'_'.$url.'_'.$i.'.gif';
        $files_array['is'][$i] =  is_file($photo_file);
        $files_array['url'][$i] =  $photo_url;
    }
    return $files_array;
}

?>
<?php
    if ( $update == 'ok' ) { // 수정하고 돌아온 상태면 부모창 새로고침 하고 창 닫기
        ?>
        <script>
            opener.parent.location='/adm/creators_list.php';
            self.close();
        </script>
        <?php
    } else { // 수정화면으로 진입했다면.
    ?>

<form method="post" action="creator_info_update.php">
    <input type="hidden" name="platform" value="<?php echo $platform;?>"/>
    <input type="hidden" name="ct_no" value="<?php echo $ct_no;?>"/>
    <div class="c_info_wrap">
        <div class="control_widget">
            <h4 class="control_title">심사관리</h4>

            <div class="c_row">
                <p class="c_row_sub">심사분류</p>
                <div class="c_row_controls">
                    <label for="judgment_accept">
                        <input type="radio" name="judgment_type" id="judgment_accept" value="y" <?php echo $row[$platform.'_is_auth'] == 2 ? 'checked' : '' ?>>
                        <span>승인</span>
                    </label>
                    <label for="judgment_reject">
                        <input type="radio" name="judgment_type" id="judgment_reject" value="n" <?php echo $row[$platform.'_is_auth'] == 3 ? 'checked' : '' ?>>
                        <span>거절</span>
                    </label>
                </div>
            </div>

            <div class="c_row">
                <p class="c_row_sub">불충족 요건</p>
                <div class="c_row_controls reasons">
                    <label for="reject_reason_1">
                        <input type="checkbox" name="reject_reason[]" id="reject_reason_1" value="1" <?php echo strpos($reject_rason, '1' ) !== false ? 'checked' : '' ;?>>
                        <span>1. 채널개설일 1개월 이상</span>
                    </label>

                    <label for="reject_reason_2">
                        <input type="checkbox" name="reject_reason[]" id="reject_reason_2" value="2" <?php echo strpos($reject_rason, '2' ) !== false ? 'checked' : '' ;?>>
                        <span>2. 구독자 수 15명 이상.</span>
                    </label>

                    <label for="reject_reason_3">
                        <input type="checkbox" name="reject_reason[]" id="reject_reason_3" value="3" <?php echo strpos($reject_rason, '3' ) !== false ? 'checked' : '' ;?>>
                        <span>3. 동영상 수 10개 이상.</span>
                    </label>

                    <label for="reject_reason_4">
                        <input type="checkbox" name="reject_reason[]" id="reject_reason_4" value="4" <?php echo strpos($reject_rason, '4' ) !== false ? 'checked' : '' ;?>>
                        <span>4. 유튜브, 트위치, 네이버TV, 아프리카TV, 카카오TV 만 가능.</span>
                    </label>

                    <label for="reject_reason_5">
                        <input type="checkbox" name="reject_reason[]" id="reject_reason_5" value="5" <?php echo strpos($reject_rason, '5' ) !== false ? 'checked' : '' ;?>>
                        <span>5. 대시보드와 신청하신 닉네임이 같아야 합니다.</span>
                    </label>

                    <label for="reject_reason_6">
                        <input type="checkbox" name="reject_reason[]" id="reject_reason_6" value="6" <?php echo strpos($reject_rason, '6' ) !== false ? 'checked' : '' ;?>>
                        <span>6. 캡처화면이 흐릿할 경우 승인이 거절될 수 있습니다.</span>
                    </label>

                    <label for="reject_reason_7">
                        <input type="checkbox" name="reject_reason[]" id="reject_reason_7" value="7" <?php echo strpos($reject_rason, '7' ) !== false ? 'checked' : '' ;?>>
                        <span>7. 자격요건에 맞지 않을 경우 승인이 거절될 수 있습니다.</span>
                    </label>

                    <label for="reject_reason_8">
                        <input type="checkbox" name="reject_reason[]" id="reject_reason_8" value="8" <?php echo strpos($reject_rason, '8' ) !== false ? 'checked' : '' ;?>>
                        <span>8. 그 외에 인증방법이 합당하지 않을 경우 승인이 거절될 수 있습니다.</span>
                    </label>
                </div>
            </div>

            <div class="control_btns">
                <button type="submit">심사결정</button>
            </div>
        </div>

        <div class="sub-title">
            <h4>
                <?php if($member['photo']) { ?>
                    <img src="<?php echo $member['photo'];?>" alt="">
                <?php } else { ?>
                    <i class="fa fa-user"></i>
                <?php } ?>
                <?php echo $g5['title'];?>
            </h4>
        </div>
        <div class="memo-send-form">
            <div class="form-group">
                <label class="" for="me_recv_mb_id"><b>플랫폼 URL</b></label>
                <div class="">
                    <div class="input-group input-group-sm">
                        <input type="text" name="me_recv_mb_id" value="<?php echo $row[$platform.'_url'] ?>" disabled id="me_recv_mb_id" class="form-control input-sm" placeholder="">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <b class="c_form_title">대시보드</b>
                <img src="<?php echo '/data/creator/'.substr($mb_id,0,2).'/'.$mb_id.'_'.$platform.'.gif';?>" />
            </div>

            <div class="form-group extra_way">
                <b class="c_form_title">그외 인증 방법</b>

                <?php
                if ( count(array_filter($extra_files['is'])) > 0 ) {
                foreach (array_filter($extra_files['is']) as $key => $val) : ?>
                    <div class="extra_way_item">
                        <img src="<?php echo $extra_files['url'][$key];?>" />
                    </div>
                <?php
                endforeach;
                }
                ?>

            </div>

            <div class="form-group">
                <label class="" for="me_memo"><b>증명할수 있는 다른방법 </b></label>
                <div class="">
                    <textarea name="me_memo" id="me_memo" rows="11" class="form-control input-sm" disabled ><?php echo $row[$platform.'_area'] ?></textarea>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    </div>
</form>