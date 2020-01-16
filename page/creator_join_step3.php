<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($is_guest) {
    alert('회원만 이용하실 수 있습니다.', '/');
}

$sql = " update {$g5['member_table']} set ct_join_step = 3 where mb_no = '{$member['mb_no']}' ";
sql_query($sql);

$mb_no = $member['mb_no'];
$sql = " SELECT * FROM g5_creators where ct_id = $mb_no ";
$row = sql_fetch($sql);

// 탈퇴 상태 확인
if ( $row[$platform.'_is_auth'] == '5' ) {
    // 탈퇴신청하고 90일 전이면
    $delete_day = $row[$platform.'_delete_day'];
    $delete_day = substr($delete_day, 0, 10);
    $submit_day =  date("Y-m-d" , strtotime($delete_day."+90 days") ) ; // 90일 후
    $date = date("Y-m-d");
    $c = intval((strtotime($submit_day)-strtotime($date)) / 86400); // 차이
    //echo $date.' -- '.$submit_day.'<br/>';
    //echo $c.'<br/>';
    //echo strtotime($submit_day).'<br/>';
    //echo strtotime($date).'<br/>';
    if ( $date < $submit_day ) {
        alert('삭제 후, 재인증 기간 D-'.$c.' 일 남았습니다. \n 그 후에 등록하시길 바랍니다.', '/bbs/page.php?hid=creator_join_step2');
    }
}

// 거절 상태 메세지
$reject = explode(',', $row[$platform.'_reject_reason']);

include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// Upload Member Photo
function apms_photo_upload($mb_id, $del_photo, $file, $f_name, $url, $platform_url, $creator_area , $mb_no ) {
    global $g5, $config, $xp;
    if(!$mb_id) return;

    //Photo Size
    $photo_w = 1024;
    $photo_h = 0;

    $photo_dir = G5_DATA_PATH.'/creator/'.substr($mb_id,0,2);
    $temp_dir = G5_DATA_PATH.'/creator/temp';

    //Delete Photo
    if ($del_photo == "true") {
        @unlink($photo_dir.'/'.$mb_id.'_'.$url.'.gif');
    }

    if ( $platform_url ) {
        $sql = " UPDATE g5_creators set ".$url."_url = '$platform_url' , ".$url."_submit = '".G5_TIME_YMDHIS."' , ";
        if ( $creator_area ) {
            $sql .= "".$url."_area = '$creator_area' ,";
        }

        $sql .= "".$url."_steps = '2' where ct_id = $mb_no ";
        sql_query($sql, false);
    }

    //Upload Photo
    if (is_uploaded_file($file[$f_name]['tmp_name'])) {
        if (!preg_match("/(\.(gif|jpe?g|bmp|png))$/i", $file[$f_name]['name'])) {
            alert(aslang('alert', 'is_image', array($file[$f_name]['name']))); //은(는) 이미지(gif/jpg/png) 파일이 아닙니다.
        } else {

            if(!is_dir(G5_DATA_PATH.'/creator')) {
                @mkdir(G5_DATA_PATH.'/creator', G5_DIR_PERMISSION);
                @chmod(G5_DATA_PATH.'/creator', G5_DIR_PERMISSION);
            }

            if(!is_dir($photo_dir)) {
                @mkdir($photo_dir, G5_DIR_PERMISSION);
                @chmod($photo_dir, G5_DIR_PERMISSION);
            }

            if(!is_dir($temp_dir)) {
                @mkdir($temp_dir, G5_DIR_PERMISSION);
                @chmod($temp_dir, G5_DIR_PERMISSION);
            }

            $filename  = $file[$f_name]['name'];
            $filename  = preg_replace('/(<|>|=)/', '', $filename);
            $filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

            $chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));
            shuffle($chars_array);
            $shuffle = implode('', $chars_array);
            $filename = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);

            $org_photo = $photo_dir.'/'.$mb_id.'_'.$url.'.gif';
            $temp_photo = $temp_dir.'/'.$filename;

            move_uploaded_file($file[$f_name]['tmp_name'], $temp_photo) or die($file[$f_name]['error']);
            chmod($temp_photo, G5_FILE_PERMISSION);
            if(is_file($temp_photo)) {
                $size = @getimagesize($temp_photo);

                //Non Image
                if (!$size[0]) {
                    @unlink($temp_photo);
                    alert(aslang('alert', 'is_bg_photo')); //등록에 실패했습니다. 이미지 파일이 정상적으로 업로드 되지 않았거나, 이미지 파일이 아닙니다.
                }

                //Animated GIF
                $is_animated = false;
                if($size[2] == 1) {
                    $is_animated = is_animated_gif($temp_photo);
                }

                if($is_animated) {
                    @unlink($temp_photo);
                    alert(aslang('alert', 'is_bg_photo_gif')); //움직이는 GIF 파일은 등록할 수 없습니다.
                } else {
                    $thumb = thumbnail($filename, $temp_dir, $temp_dir, $photo_w, $photo_h, true, true);
                    if($thumb) {
                        if ($size[2] == 2) { //jpg
                            $src = @imagecreatefromjpeg($temp_dir.'/'.$thumb);
                            @imagegif($src, $temp_dir.'/'.$thumb);
                        } else if ($size[2] == 3) { //png
                            $src = @imagecreatefrompng($temp_dir.'/'.$thumb);
                            @imagealphablending($src, true);
                            @imagegif($src, $temp_dir.'/'.$thumb);
                        }
                        chmod($temp_dir.'/'.$thumb, G5_FILE_PERMISSION);
                        copy($temp_dir.'/'.$thumb, $org_photo);
                        chmod($org_photo, G5_FILE_PERMISSION);
                        @unlink($temp_dir.'/'.$thumb);
                        @unlink($temp_photo);
                    } else {
                        @unlink($temp_photo);
                        //등록에 실패했습니다. 이미지 파일이 정상적으로 업로드 되지 않았거나, 이미지 파일이 아닙니다.
                        alert(aslang('alert', 'is_bg_photo'), G5_BBS_URL.'/page.php?hid=creator_join_step3&platform='.$url.'&mo='.$mo);
                    }
                }
            }
        }
    }
    
    // 추가 이미지 파일 업로드

    $files_count = count(array_filter($_FILES['extra']['tmp_name']));
    if ( $files_count ) { // 파일이 있다면
        echo '<br/>';

        foreach ( array_filter($_FILES['extra']['name']) as $item) { // 빈 배열 제거 후 파일 확장자로 검사
            if (!preg_match("/(\.(gif|jpe?g|bmp|png))$/i", $item )) {
                alert(aslang('alert', 'is_image', array($item))); //은(는) 이미지(gif/jpg/png) 파일이 아닙니다.
            }
        }

        if(!is_dir(G5_DATA_PATH.'/creator')) {
            @mkdir(G5_DATA_PATH.'/creator', G5_DIR_PERMISSION);
            @chmod(G5_DATA_PATH.'/creator', G5_DIR_PERMISSION);
        }

        if(!is_dir($photo_dir)) {
            @mkdir($photo_dir, G5_DIR_PERMISSION);
            @chmod($photo_dir, G5_DIR_PERMISSION);
        }

        if(!is_dir($temp_dir)) {
            @mkdir($temp_dir, G5_DIR_PERMISSION);
            @chmod($temp_dir, G5_DIR_PERMISSION);
        }

        foreach ( $_FILES['extra']['name'] as $key => $val ) {

            if ( $val != '' ) {

                $filename = $val;
                $filename = preg_replace('/(<|>|=)/', '', $filename);
                $filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);
                $chars_array = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
                shuffle($chars_array);
                $shuffle = implode('', $chars_array);
                $filename = abs(ip2long($_SERVER['REMOTE_ADDR'])) . '_' . substr($shuffle, 0, 8) . '_' . replace_filename($filename);

                $org_photo = $photo_dir . '/' . $mb_id . '_' . $url . '_' . $key . '.gif';
                $temp_photo = $temp_dir . '/' . $filename;

                move_uploaded_file($_FILES['extra']['tmp_name'][$key], $temp_photo) or die($_FILES['extra']['error'][$key]);
                chmod($temp_photo, G5_FILE_PERMISSION);
                if (is_file($temp_photo)) {
                    $size = @getimagesize($temp_photo);

                    //Non Image
                    if (!$size[0]) {
                        @unlink($temp_photo);
                        alert(aslang('alert', 'is_bg_photo')); //등록에 실패했습니다. 이미지 파일이 정상적으로 업로드 되지 않았거나, 이미지 파일이 아닙니다.
                    }

                    //Animated GIF
                    $is_animated = false;
                    if ($size[2] == 1) {
                        $is_animated = is_animated_gif($temp_photo);
                    }

                    if ($is_animated) {
                        @unlink($temp_photo);
                        alert(aslang('alert', 'is_bg_photo_gif')); //움직이는 GIF 파일은 등록할 수 없습니다.
                    } else {
                        $thumb = thumbnail($filename, $temp_dir, $temp_dir, $photo_w, $photo_h, true, true);
                        if ($thumb) {
                            if ($size[2] == 2) { //jpg
                                $src = @imagecreatefromjpeg($temp_dir . '/' . $thumb);
                                @imagegif($src, $temp_dir . '/' . $thumb);
                            } else if ($size[2] == 3) { //png
                                $src = @imagecreatefrompng($temp_dir . '/' . $thumb);
                                @imagealphablending($src, true);
                                @imagegif($src, $temp_dir . '/' . $thumb);
                            }
                            chmod($temp_dir . '/' . $thumb, G5_FILE_PERMISSION);
                            copy($temp_dir . '/' . $thumb, $org_photo);
                            chmod($org_photo, G5_FILE_PERMISSION);
                            @unlink($temp_dir . '/' . $thumb);
                            @unlink($temp_photo);
                        } else {
                            @unlink($temp_photo);
                            //등록에 실패했습니다. 이미지 파일이 정상적으로 업로드 되지 않았거나, 이미지 파일이 아닙니다.
                            alert(aslang('alert', 'is_bg_photo'), G5_BBS_URL . '/page.php?hid=creator_join_step3&platform=' . $url . '&mo=' . $mo);
                        }
                    }
                }
            }
        }
    }
}

// 설정 저장-------------------------------------------------------
if ($mode == "u") {
//    print_r($_FILES);
    $f_name = 'platform_photo';
    $url = $platform_url;

    apms_photo_upload($member['mb_id'], $delete_dashboard, $_FILES, $f_name, $platform, $url, $platform_area, $mb_no ); //Save

    foreach($_POST as $key => $val ) :
        if ( strpos($key, 'extra_delete') !== false ) {
            if ( $val == 'true' ) {
                $extra_num = preg_replace("/[^0-9]*/s","", $key);
                extra_img_delete($member['mb_id'], $platform, $extra_num);
            }
        }
    endforeach;
    goto_url(G5_BBS_URL.'/page.php?hid=creator_join_step4&platform='.$platform.'&mo='.$mo);
}
//--------------------------------------------------------------------

$myphoto = apms_photo_creator_url($member['mb_id'], $platform);

// Load Creator Photo ksm
function apms_photo_creator_url($mb_id='', $url='') {
    global $xp;
    if(!$mb_id) return $xp['xp_photo_url'];
    $mb_dir = substr($mb_id,0,2);
    $photo_url = G5_DATA_URL.'/creator/'.$mb_dir.'/'.$mb_id.'_'.$url.'.gif';
    $photo_file = G5_DATA_PATH.'/creator/'.$mb_dir.'/'.$mb_id.'_'.$url.'.gif';
    if(!is_file($photo_file)) return $xp['xp_photo_url'];
    return $photo_url;
}

$extra_files =  extra_files($member['mb_id'], $platform);
//print_r($extra_files);

function extra_files($mb_id='', $url='') {
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

function extra_img_delete($mb_id='', $url='', $extra_num) {
    $photo_dir = G5_DATA_PATH.'/creator/'.substr($mb_id,0,2);
    @unlink($photo_dir.'/'.$mb_id.'_'.$url.'_'.$extra_num.'.gif');
}

//    <!-- 제목 변수 -->
$subject = '';
switch($mo) {
    case 'submit':
        $subject = '등록';
        break;
    case 'mod':
        $subject = '수정';
        break;
    case 'del':
        $subject = '삭제';
        break;
}

?>

<style>
    .page-content {
        line-height: 22px;
        word-break: keep-all;
        word-wrap: break-word;
    }
    .page-content .article-title {
        color: #0083B9;
        font-weight: bold;
        padding-top: 30px;
        padding-bottom: 10px;
    }
    .page-content ul {
        list-style: none;
        padding: 0;
        margin: 0;
        font-weight: normal;
    }
    .page-content ol {
        margin-top: 0;
        margin-bottom: 15px;
    }
    .page-content p {
        margin: 0 0 15px;
        padding: 0;
    }
    .page-content table {
        border-top: 2px solid #999;
        border-bottom: 1px solid #ddd;
    }
    .page-content td,
    .page-content th {
        line-height: 1.6 !important;
    }
    .page-content table.tbl-center td,
    .page-content table.tbl-center th,
    .page-content td.text-center,
    .page-content th.text-center {
        text-align: center !important;
    }
</style>

<div class="page-content register_wrap">

    <ul class="i_process">
        <li>
            <div>약관동의</div>
        </li>
        <li>
            <div>플랫폼 선택</div>
        </li>
        <li class="active">
            <div>정보 입력</div>
        </li>
        <li>
            <div>완료</div>
        </li>
    </ul>

    <div class="creator_register_wrap step3">

        <div class="creator_register_wrap">

            <form method="post" class="creator_register" enctype="multipart/form-data">

                <input type="hidden" name="mode" value="u">

                <div class="i_title">
                    <h3>크리에이터 <?php echo $subject; ?>하기 (<?php echo $platform;?>)</h3>
                </div>
                <?php
                foreach ( $reject as $item ) :
                    if ( $item == '1') echo '채널개설일 1개월 이상.<br/>';
                    if ( $item == '2') echo '구독자 수 15명 이상.<br/>';
                    if ( $item == '3') echo '동영상 수 10개 이상.<br/>';
                    if ( $item == '4') echo '유튜브, 트위치, 네이버TV, 아프리카TV, 카카오TV 만 가능.<br/>';
                    if ( $item == '5') echo '대시보드와 신청하신 닉네임이 같아야 합니다.<br/>';
                    if ( $item == '6') echo '캡처화면이 흐릿할 경우 승인이 거절될 수 있습니다.<br/>';
                    if ( $item == '7') echo '자격요건에 맞지 않을 경우 승인이 거절될 수 있습니다.<br/>';
                    if ( $item == '8') echo '그 외에 인증방법이 합당하지 않을 경우 승인이 거절될 수 있습니다.';
                endforeach;
                ?>
                <div class="i_form">
                    <div class="i_form_row channel_link">
                        <div class="i_label">채널링크</div>
                        <div class="i_control">
                            <input type="url" name="platform_url" value="<?php echo $row[$platform.'_url'];?>" required >
                        </div>
                    </div>

                    <div class="i_form_row dashboard">
                        <div class="i_label">대시보드 스크린샷</div>
                        <div class="i_control">
                            <div class="upload_box">
                                <label id="upload_preview" for="upload_dashboard">
                                    <button type="button" class="cancel_img_btn"><i class='icon-cancel-circle'></i></button>
                                    <?php echo ($myphoto) ? '<img src="'.$myphoto.'" alt="">' : '<span style="font-size: 18px">+<br/>Upload</span>'; ?>
                                </label>
                                <input type="file" name="platform_photo" id="upload_dashboard">
                                <input type="hidden" value="false" id="delete_dashboard" class="extra_delete" name="delete_dashboard"/>
                            </div>
                            <div class="upload_comment">
                                확인을 승인하려면 스크린샷에 키가 포함 되어 있는지 확인하십시오.<br/>
                                예를 들어 최대 이미지 크기는 5M 입니다.
                            </div>
                        </div>
                    </div>

                    <div class="i_form_row proof">
                        <div class="i_label">증명할수있는 다른방법</div>
                        <div class="i_control">
                            <textarea name="platform_area" style="max-width: 700px;" placeholder="입력해주세요"><?php echo get_text($row[$platform.'_area'], 0) ?></textarea>
                        </div>
                    </div>

                    <div class="i_form_row extra_proof">
                        <div class="i_label"></div>
                        <div class="extra_proof_wrap">
                            <?php
                            if ( count(array_filter($extra_files['is'])) > 0 ) {
                                foreach (array_filter($extra_files['is']) as $key => $val) : ?>
                                    <div class="extra_proof_box">
                                        <div class="i_control">
                                            <label id="upload_preview_<?php echo $key ?>"
                                                   for="extra_file_<?php echo $key ?>">
                                                <button type="button" class="cancel_img_btn"><i class='icon-cancel-circle'></i></button>
                                                <img src="<?php echo $extra_files['url'][$key] ?>" alt="">
                                            </label>
                                            <input type="file" name="extra[]" id="extra_file_<?php echo $key ?>">
                                            <input type="hidden" name="extra_delete_<?php echo $key ?>" id="extra_delete_<?php echo $key ?>" class="extra_delete" value="false"/>

                                        </div>
                                    </div>
                                <?php
                                endforeach;
                            } else { ?>
                            <div class="extra_proof_box">
                                <div class="i_control">
                                    <label id="upload_preview_0" for="extra_file_0">
                                        <button type="button" class="cancel_img_btn"><i class='icon-cancel-circle'></i></button>
                                    </label>
                                    <input type="file" name="extra[]" id="extra_file_0">
                                    <input type="hidden" name="extra_delete_0" id="extra_delete_0" class="extra_delete" value="false"/>
                                </div>
                            </div>
                            <div class="extra_proof_box">
                                <div class="i_control">
                                    <label id="upload_preview_1" for="extra_file_1">
                                        <button type="button" class="cancel_img_btn"><i class='icon-cancel-circle'></i></button>
                                    </label>
                                    <input type="file" name="extra[]" id="extra_file_1">
                                    <input type="hidden" name="extra_delete_1" id="extra_delete_1" class="extra_delete" value="false"/>
                                </div>
                            </div>
                            <div class="extra_proof_box">
                                <div class="i_control">
                                    <label id="upload_preview_2" for="extra_file_2">
                                        <button type="button" class="cancel_img_btn"><i class='icon-cancel-circle'></i></button>
                                    </label>
                                    <input type="file" name="extra[]" id="extra_file_2">
                                    <input type="hidden" name="extra_delete_2" id="extra_delete_2" class="extra_delete" value="false"/>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>

                        <button type="button" id="ep_add_btn">업로드 추가</button>
                    </div>

                    <div class="creator_register_btns">
                        <button type="button" class="creator_cancel" onclick="history.back()">취소</button>
                        <button type="submit" id="creator_apply">제출하기</button>
                    </div>

                </div>
        </div>
    </div>
</div>
</form>

<div class="h30"></div>

<script>
    const creatorJoin = new FileUpload({
        selector: '#upload_dashboard',
        preview: '#upload_preview'
    })

    const addUploader = new AddUpload({
        addBtn: '#ep_add_btn',
        wrapper: '.extra_proof_wrap'
    })

    $(document).on('click', '.cancel_img_btn', function(){
        $(this).parent().siblings('.extra_delete').val('true');
    });
</script>