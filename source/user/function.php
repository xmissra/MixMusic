<?php
function left_plugin(){
	global $db;
        $sql = "select * from ".tname('plugin')." where in_type=2 and in_isindex=1";
        $query = $db->query($sql);
        $count = $db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
        if($count > 0){
                $app = '<ul class="app_list">';
                while($row = $db->fetch_array($query)){
                        $app .= '<li><img src="'.IN_PATH.'source/plugin/'.$row['in_dir'].'/icon.jpg" onerror="this.src=\''.IN_PATH.'static/user/images/icon/app.gif\'"><a href="'.rewrite_mode('plugin.php/'.$row['in_dir'].'/index/').'">'.$row['in_name'].'</a></li>';
                }
                return $app.'</ul>';
        }else{
                return NULL;
        }
}
function top_message($uid){
	global $db;
        $count = $db->num_rows($db->query("select count(*) from ".tname('message')." where in_isread=0 and in_uids=".$uid));
        if($count > 0){
                return $count;
        }else{
                return false;
        }
}
function getlevel($rank, $href=0){
	if($rank >= 100 && $rank < 200){
		$level = $href == 1 ? '<a href="'.rewrite_mode('user.php/profile/credit/').'" title="经验值：'.$rank.'"><img src="'.IN_PATH.'static/user/images/level/star_level1.gif" align="absmiddle"></a>' : '<img src="'.IN_PATH.'static/user/images/level/star_level1.gif" align="absmiddle">';
	}elseif($rank >= 200 && $rank < 300){
		$level = $href == 1 ? '<a href="'.rewrite_mode('user.php/profile/credit/').'" title="经验值：'.$rank.'"><img src="'.IN_PATH.'static/user/images/level/star_level2.gif" align="absmiddle"></a>' : '<img src="'.IN_PATH.'static/user/images/level/star_level2.gif" align="absmiddle">';
	}elseif($rank >= 300 && $rank < 400){
		$level = $href == 1 ? '<a href="'.rewrite_mode('user.php/profile/credit/').'" title="经验值：'.$rank.'"><img src="'.IN_PATH.'static/user/images/level/star_level3.gif" align="absmiddle"></a>' : '<img src="'.IN_PATH.'static/user/images/level/star_level3.gif" align="absmiddle">';
	}elseif($rank >= 400 && $rank < 500){
		$level = $href == 1 ? '<a href="'.rewrite_mode('user.php/profile/credit/').'" title="经验值：'.$rank.'"><img src="'.IN_PATH.'static/user/images/level/star_level4.gif" align="absmiddle"></a>' : '<img src="'.IN_PATH.'static/user/images/level/star_level4.gif" align="absmiddle">';
	}elseif($rank >= 500 && $rank < 600){
		$level = $href == 1 ? '<a href="'.rewrite_mode('user.php/profile/credit/').'" title="经验值：'.$rank.'"><img src="'.IN_PATH.'static/user/images/level/star_level5.gif" align="absmiddle"></a>' : '<img src="'.IN_PATH.'static/user/images/level/star_level5.gif" align="absmiddle">';
	}elseif($rank >= 600 && $rank < 700){
		$level = $href == 1 ? '<a href="'.rewrite_mode('user.php/profile/credit/').'" title="经验值：'.$rank.'"><img src="'.IN_PATH.'static/user/images/level/star_level6.gif" align="absmiddle"></a>' : '<img src="'.IN_PATH.'static/user/images/level/star_level6.gif" align="absmiddle">';
	}elseif($rank >= 700 && $rank < 800){
		$level = $href == 1 ? '<a href="'.rewrite_mode('user.php/profile/credit/').'" title="经验值：'.$rank.'"><img src="'.IN_PATH.'static/user/images/level/star_level7.gif" align="absmiddle"></a>' : '<img src="'.IN_PATH.'static/user/images/level/star_level7.gif" align="absmiddle">';
	}elseif($rank >= 800 && $rank < 900){
		$level = $href == 1 ? '<a href="'.rewrite_mode('user.php/profile/credit/').'" title="经验值：'.$rank.'"><img src="'.IN_PATH.'static/user/images/level/star_level8.gif" align="absmiddle"></a>' : '<img src="'.IN_PATH.'static/user/images/level/star_level8.gif" align="absmiddle">';
	}elseif($rank >= 900 && $rank < 1000){
		$level = $href == 1 ? '<a href="'.rewrite_mode('user.php/profile/credit/').'" title="经验值：'.$rank.'"><img src="'.IN_PATH.'static/user/images/level/star_level9.gif" align="absmiddle"></a>' : '<img src="'.IN_PATH.'static/user/images/level/star_level9.gif" align="absmiddle">';
	}elseif($rank >= 1000){
		$level = $href == 1 ? '<a href="'.rewrite_mode('user.php/profile/credit/').'" title="经验值：'.$rank.'"><img src="'.IN_PATH.'static/user/images/level/star_level10.gif" align="absmiddle"></a>' : '<img src="'.IN_PATH.'static/user/images/level/star_level10.gif" align="absmiddle">';
	}else{
		$level = NULL;
	}
	return $level;
}
function getsign($sign, $signtime){
        $arr = array(0, 1, 2, 3, 4, 5, 6, 7);
        $week = date('w', strtotime(date('Y-m-01')));
        $day = '<li class="calendarli calendarweek">'.str_replace($arr, array('日', '一', '二', '三', '四', '五', '六'), $week).'</li>';
        $day = $day.'<li class="calendarli calendarweek">'.str_replace($arr, array('一', '二', '三', '四', '五', '六', '日'), $week).'</li>';
        $day = $day.'<li class="calendarli calendarweek">'.str_replace($arr, array('二', '三', '四', '五', '六', '日', '一'), $week).'</li>';
        $day = $day.'<li class="calendarli calendarweek">'.str_replace($arr, array('三', '四', '五', '六', '日', '一', '二'), $week).'</li>';
        $day = $day.'<li class="calendarli calendarweek">'.str_replace($arr, array('四', '五', '六', '日', '一', '二', '三'), $week).'</li>';
        $day = $day.'<li class="calendarli calendarweek">'.str_replace($arr, array('五', '六', '日', '一', '二', '三', '四'), $week).'</li>';
        $day = $day.'<li class="calendarli calendarweek">'.str_replace($arr, array('六', '日', '一', '二', '三', '四', '五'), $week).'</li>';
        for($i = 1; $i < date('t') + 1; $i++){
                $start = intval(date('d')) - $sign;
                if(DateDiff(date('Y-m-d', strtotime($signtime)), date('Y-m-d')) == 0){
                        if($i < intval(date('d')) + 1 && $i > $start){
                                $limit = $i - $start;
                                $p = $limit * IN_SIGNDAYPOINTS;
                                $r = $limit * IN_SIGNDAYRANK;
                                $day .= $i == intval(date('d')) ? '<li class="calendarli on_today" onmouseover="$(\'day_'.$i.'\').style.display=\'block\'" onmouseout="$(\'day_'.$i.'\').style.display=\'none\'"><a style="cursor:pointer">'.$i.'</a><div class="dayevents" id="day_'.$i.'" style="display:none"><ul><li class="dayeventsli">出勤['.$p.']['.$r.']</li></ul></div></li>' : '<li class="calendarli on_select" onmouseover="$(\'day_'.$i.'\').style.display=\'block\'" onmouseout="$(\'day_'.$i.'\').style.display=\'none\'"><a style="cursor:pointer">'.$i.'</a><div class="dayevents" id="day_'.$i.'" style="display:none"><ul><li class="dayeventsli">出勤['.$p.']['.$r.']</li></ul></div></li>';
                        }else{
                                $day .= $i > intval(date('d')) ? '<li class="calendarli on_link" onmouseover="$(\'day_'.$i.'\').style.display=\'block\'" onmouseout="$(\'day_'.$i.'\').style.display=\'none\'"><a style="cursor:pointer">'.$i.'</a><div class="dayevents" id="day_'.$i.'" style="display:none"><ul><li class="dayeventsli">待签</li></ul></div></li>' : '<li class="calendarli on_link" onmouseover="$(\'day_'.$i.'\').style.display=\'block\'" onmouseout="$(\'day_'.$i.'\').style.display=\'none\'"><a style="cursor:pointer">'.$i.'</a><div class="dayevents" id="day_'.$i.'" style="display:none"><ul><li class="dayeventsli">旷工</li></ul></div></li>';
                        }
                }else{
                        if($i < intval(date('d')) && $i > $start - 1){
                                $limit = $i - $start + 1;
                                $p = $limit * IN_SIGNDAYPOINTS;
                                $r = $limit * IN_SIGNDAYRANK;
                                $day .= '<li class="calendarli on_select" onmouseover="$(\'day_'.$i.'\').style.display=\'block\'" onmouseout="$(\'day_'.$i.'\').style.display=\'none\'"><a style="cursor:pointer">'.$i.'</a><div class="dayevents" id="day_'.$i.'" style="display:none"><ul><li class="dayeventsli">出勤['.$p.']['.$r.']</li></ul></div></li>';
                        }else{
                                $day .= $i < intval(date('d')) ? '<li class="calendarli on_link" onmouseover="$(\'day_'.$i.'\').style.display=\'block\'" onmouseout="$(\'day_'.$i.'\').style.display=\'none\'"><a style="cursor:pointer">'.$i.'</a><div class="dayevents" id="day_'.$i.'" style="display:none"><ul><li class="dayeventsli">旷工</li></ul></div></li>' : '<li class="calendarli on_link" onmouseover="$(\'day_'.$i.'\').style.display=\'block\'" onmouseout="$(\'day_'.$i.'\').style.display=\'none\'"><a id="a_'.$i.'" style="cursor:pointer">'.$i.'</a><div class="dayevents" id="day_'.$i.'" style="display:none"><ul><li class="dayeventsli">待签</li></ul></div></li>';
                        }
                }
        }
	return $day;
}
function getblog($content, $tag=0, $len=100){
	if($tag){
		$content = getlenth(strip_tags(htmlspecialchars_decode($content, ENT_QUOTES)), $len);
	}else{
		$search = array('static/user/images/face/', 'data/attachment/photo/');
		$replace = array('http://'.$_SERVER['HTTP_HOST'].IN_PATH.'static/user/images/face/', 'http://'.$_SERVER['HTTP_HOST'].IN_PATH.'data/attachment/photo/');
		$content = str_replace($search, $replace, htmlspecialchars_decode($content, ENT_QUOTES));
	}
	return $content;
}
function set_special($key, $id, $type='del'){
	$post = isset($_POST[$key]) ? $_POST[$key] : NULL;
	$value = implode(',', $post);
	$arr = explode(',', $value);
	$field = $type == 'join' ? 'in_uid' : 'in_specialid';
	for($i = 0; $i < count($arr); $i++){
		$array[] = getfield('music', $field, 'in_id', intval($arr[$i])) == $id ? intval($arr[$i]) : 0;
	}
	return implode(',', $array);
}
function getuserpage($sqlstr, $pagesok, $pathinfo){
	global $db;
	$self = is_utf8(str_replace('['.IN_PATH, '', '['.$_SERVER['PHP_SELF']));
	$url = explode('/', $_SERVER['PATH_INFO']);
	$page = empty($url[$pathinfo]) ? 1 : intval(str_replace('p', '', $url[$pathinfo]));
	$pages = $page <= 0 ? 1 : $page;
 	$nums = $db->num_rows($db->query(preg_replace('/^select \* from/i', 'select count(*) from', $sqlstr, 1)));
	$num = $nums == 0 ? 1 : $nums;
	$pagejs = ceil($num / $pagesok);
	if($pages > $pagejs){
		$pages = $pagejs;
	}
	$result = $db->query($sqlstr." LIMIT ".$pagesok * ($pages - 1).",".$pagesok);
 	$str = "<div class=\"page\"><em>&nbsp;".$nums."&nbsp;</em>";
	$str .= "<a href=\"".rewrite_mode(!empty($url[$pathinfo]) ? str_replace($url[$pathinfo], 'p1', $self) : $self.'p1/')."\" class=\"first\">首页</a>";
	if($pages > 1){
		$str .= "<a href=\"".rewrite_mode(!empty($url[$pathinfo]) ? str_replace($url[$pathinfo], 'p'.($pages - 1), $self) : $self.'p'.($pages - 1).'/')."\" class=\"prev\">&lsaquo;&lsaquo;</a>";
	}
	if($pagejs <= 10){
  		for($i=1;$i<=$pagejs;$i++){
   			if($i == $pages){
   				$str .= "<strong>".$i."</strong>";
   			}else{
   				$str .= "<a href=\"".rewrite_mode(!empty($url[$pathinfo]) ? str_replace($url[$pathinfo], 'p'.$i, $self) : $self.'p'.$i.'/')."\">".$i."</a>";
   			}
 	 	}
	}else{
 		if($pages >= 12){
 			for($i=$pages-5;$i<=$pages+6;$i++){
   				if($i <= $pagejs){
   				        if($i == $pages){
   						$str .= "<strong>".$i."</strong>";
   				        }else{
   						$str .= "<a href=\"".rewrite_mode(!empty($url[$pathinfo]) ? str_replace($url[$pathinfo], 'p'.$i, $self) : $self.'p'.$i.'/')."\">".$i."</a>";
   				        }
    				}
  			}
  			if($i <= $pagejs){ 
    				$str .= "...";
	    			$str .= "<a href=\"".rewrite_mode(!empty($url[$pathinfo]) ? str_replace($url[$pathinfo], 'p'.$pagejs, $self) : $self.'p'.$pagejs.'/')."\">".$pagejs."</a>";
   			}
   		}else{
  			for($i=1;$i<=12;$i++){
   				if($i == $pages){
   					$str .= "<strong>".$i."</strong>";
   				}else{
   					$str .= "<a href=\"".rewrite_mode(!empty($url[$pathinfo]) ? str_replace($url[$pathinfo], 'p'.$i, $self) : $self.'p'.$i.'/')."\">".$i."</a>";
   				}
 			}
 			if($i <= $pagejs){
      				$str .= "...";
	  			$str .= "<a href=\"".rewrite_mode(!empty($url[$pathinfo]) ? str_replace($url[$pathinfo], 'p'.$pagejs, $self) : $self.'p'.$pagejs.'/')."\">".$pagejs."</a>";
    			}
 		 }
	}
	if($pages < $pagejs){
		$str .= "<a href=\"".rewrite_mode(!empty($url[$pathinfo]) ? str_replace($url[$pathinfo], 'p'.($pages + 1), $self) : $self.'p'.($pages + 1).'/')."\" class=\"next\">&rsaquo;&rsaquo;</a>";
	}
	$str .= "<a href=\"".rewrite_mode(!empty($url[$pathinfo]) ? str_replace($url[$pathinfo], 'p'.$pagejs, $self) : $self.'p'.$pagejs.'/')."\" class=\"last\">尾页</a>";
	$str .= "<em>&nbsp;".$pages."/".$pagejs."&nbsp;</em></div>";
	$arr = array($str, $result, $nums, $pagejs);
	return $arr;
}
?>