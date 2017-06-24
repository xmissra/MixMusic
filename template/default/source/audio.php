<?php
include '../../../source/system/db.class.php';
include '../../../source/system/user.php';
global $db,$userlogined,$missra_in_userid,$missra_in_points,$missra_in_grade;
$id = intval(SafeRequest("id","get"));
if($row = $db->getrow("select * from ".tname('music')." where in_id=".$id)){
        if($row['in_grade'] == 1){
                $userlogined or exit(header('location:'.rewrite_mode('index.php/page/login/')));
                if($missra_in_grade < $row['in_grade']){
                        exit(header('location:'.rewrite_mode('user.php/profile/vip/')));
                }
        }elseif($row['in_grade'] == 2){
                $userlogined or exit(header('location:'.rewrite_mode('index.php/page/login/')));
                if($missra_in_points < $row['in_points']){
                        exit(header('location:'.rewrite_mode('user.php/profile/pay/')));
                }else{
                        $cookie = 'in_download_music_'.$row['in_id'];
                        if(empty($_COOKIE[$cookie])){
		                setcookie($cookie, 'have', time()+86400, IN_PATH);
		                $db->query("update ".tname('user')." set in_points=in_points-".$row['in_points']." where in_userid=".$missra_in_userid);
                        }
                }
        }
        $db->query("update ".tname('music')." set in_downhits=in_downhits+1 where in_id=".$row['in_id']);
        $file = geturl($row['in_audio']);
        $headers = get_headers($file, 1);
        if(array_key_exists('Content-Length', $headers)){
                $filesize = $headers['Content-Length'];
        }else{
                $filesize = strlen(@file_get_contents($file));
        }
        header("Content-Type: application/force-download");
        header("Content-Disposition: attachment; filename=".basename($file));
        header("Content-Length: ".$filesize);
        readfile($file);
}else{
        echo html_message("错误信息","数据不存在或已被删除！");
}
?>