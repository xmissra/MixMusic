<?php
function getavatar($uid, $size='small'){
	global $db;
	$row = $db->getrow("select * from ".tname('user')." where in_userid=".intval($uid));
	if(IN_UCOPEN == 1 && intval($row['in_ucid']) > 0){
		require_once IN_ROOT.'./client/ucenter.php';
		$avatar = UC_API."/avatar.php?uid=".$row['in_ucid']."&size=".$size;
	}elseif(empty($row['in_avatar']) && !empty($row['in_qqopen']) && !empty($row['in_qqimg'])){
		$avatar = $row['in_qqimg'];
	}else{
		$avatar = geturl($row['in_avatar'], 'avatar');
	}
	return $avatar;
}
function getphoto($id){
	global $db;
	$photo = $db->getone("select in_url from ".tname('photo')." where in_id=".$id);
	return geturl($photo, 'photo');
}
function geturl($file, $type=''){
	if(preg_match('/^(data\/attachment|plugin.php)/', $file)){
		$url = "http://".$_SERVER['HTTP_HOST'].IN_PATH.$file;
	}elseif(empty($file)){
		switch($type){
                        case 'lyric':
		                $url = "http://".$_SERVER['HTTP_HOST'].IN_PATH."static/user/nolyric.lrc";
		                break;
                        case 'cover':
		                $url = "http://".$_SERVER['HTTP_HOST'].IN_PATH."static/user/images/nocover.png";
		                break;
                        case 'avatar':
		                $url = "http://".$_SERVER['HTTP_HOST'].IN_PATH."static/user/images/noavatar.jpg";
		                break;
                        case 'photo':
		                $url = "http://".$_SERVER['HTTP_HOST'].IN_PATH."static/user/images/nophoto.png";
		                break;
                        default:
		                $url = NULL;
		                break;
		}
	}else{
		$url = $file;
	}
	return $url;
}
function getlink($id, $table=''){
	switch($table){
		case 'photogroup':
			$link = rewrite_mode('user.php/photo/group/'.$id.'/');
			break;
		case 'photo':
			$link = rewrite_mode('user.php/photo/info/'.$id.'/');
			break;
		case 'blog':
			$link = rewrite_mode('user.php/blog/info/'.$id.'/');
			break;
		default:
			$space = array('s_feed', 's_music', 's_special', 's_singer', 's_video', 's_article', 's_photo', 's_blog');//新增Article模块
			$info = array('music', 'special', 'singer', 'video', 'article');//新增Article模块
			$list = array('class', 'specialclass', 'singerclass', 'videoclass', 'articleclass');//新增Article模块
			if(in_array($table, $space)){
			        $link = rewrite_mode('user.php/space/'.str_replace('s_', '', $table).'/'.$id.'/');
			}elseif(in_array($table, $info)){
			        $link = rewrite_mode('index.php/'.$table.'/'.$id.'/', true);
			}elseif(in_array($table, $list)){
			        $class = $table == 'class' ? 'class' : str_replace('class', '_class', $table);
			        $link = rewrite_mode('index.php/'.$class.'/'.$id.'/', true);
			}elseif($table == 'tag'){
			        $link = rewrite_mode('index.php/search/'.$id.'/');
			}else{
			        $link = rewrite_mode('user.php/'.$id.'/');
			}
			break;
	}
	return $link;
}
function getsex($str){
	if($str == 1){
		$sex = '美女';
	}else{
		$sex = '帅哥';
	}
	return $sex;
}
function getlenth($str, $len){
	if(empty($str) || !is_numeric($len) || iconv_strlen($str, strtoupper(IN_CHARSET)) <= $len){
		return $str;
	}else{
		return iconv_substr($str, 0, $len, strtoupper(IN_CHARSET)).'...';
	}
}
function formatsize($size){
	$prec = 3;
	$size = round(abs($size));
	$units = array(0 => " B", 1 => " KB", 2 => " MB", 3 => " GB", 4 => " TB");
	if($size == 0){
		return str_repeat(" ", $prec)."0".$units[0];
	}
	$unit = min(4, floor(log($size) / log(2) / 10));
	$size = $size * pow(2, -10 * $unit);
	$digi = $prec - 1 - floor(log($size) / log(10));
	$size = round($size * pow(10, $digi)) * pow(10, -$digi);
	return $size.$units[$unit];
}
function datetime($date){
	$limit = time() - strtotime($date);
	if($limit < 5){
		$show_t = "刚刚";
	}
	if($limit >= 5 && $limit < 60){
		$show_t = $limit."秒前";
	}
	if($limit >= 60 && $limit < 3600){
		$show_t = sprintf("%01.0f", $limit / 60)."分钟前";
	}
	if($limit >= 3600 && $limit < 86400){
		$show_t = sprintf("%01.0f", $limit / 3600)."小时前";
	}
	if($limit >= 86400 && $limit < 2592000){
		$show_t = sprintf("%01.0f", $limit / 86400)."天前";
	}
	if($limit >= 2592000 && $limit < 31104000){
		$show_t = sprintf("%01.0f", $limit / 2592000)."个月前";
	}
	if($limit >= 31104000){
		$show_t = $date;
	}
 	return $show_t;
}
function fileext($file){
	return strtolower(trim(substr(strrchr($file, '.'), 1)));
}
function tname($name){
	return IN_DBTABLE.$name;
}
function IsNum($str){
	if(is_numeric($str)){
		return true;
	}else{
		return false;
	}
}
function IsNul($str){
	if(is_string($str) && !empty($str)){
		return true;
	}else{
		return false;
	}
}
function detect_encoding($str){
	$chars = NULL;
	$list = array('GBK', 'UTF-8');
	foreach($list as $item){
		$tmp = mb_convert_encoding($str, $item, $item);
		if(md5($tmp) == md5($str)){
                        $chars = $item;
		}
	}
	return strtolower($chars) !== IN_CHARSET ? iconv($chars, strtoupper(IN_CHARSET).'//IGNORE', $str) : $str;
}
function is_utf8($string){
	if(IN_CHARSET == 'utf-8'){
		return detect_encoding($string);
	}else{
                if(preg_match('%^(?:[\x09\x0A\x0D\x20-\x7E] | [\xC2-\xDF][\x80-\xBF] | \xE0[\xA0-\xBF][\x80-\xBF] | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} | \xED[\x80-\x9F][\x80-\xBF] | \xF0[\x90-\xBF][\x80-\xBF]{2} | [\xF1-\xF3][\x80-\xBF]{3} | \xF4[\x80-\x8F][\x80-\xBF]{2})*$%xs', $string)){
                        if(function_exists('mb_convert_encoding')){
                                return mb_convert_encoding($string, 'GBK', 'UTF-8');
                        }else{
                                return iconv('UTF-8', 'GBK//IGNORE', $string);
                        }
                }else{
                        return $string;
                }
	}
}
function escape($str){
        $code = PHP_OS == 'Linux' ? 'UCS-2BE//IGNORE' : 'UCS-2//IGNORE';
        preg_match_all("/[\x80-\xff].|[\x01-\x7f]+/", $str, $r);
        $ar = $r[0];
        foreach($ar as $k => $v){
                if(ord($v[0]) < 128){
                        $ar[$k] = rawurlencode($v);
                }else{
                        $ar[$k] = '%u'.bin2hex(iconv(strtoupper(IN_CHARSET), $code, $v));
                }
        }
        return implode('', $ar);
}
function unescape($str){
        $code = PHP_OS == 'Linux' ? 'UCS-2BE' : 'UCS-2';
        $str = rawurldecode($str);
        preg_match_all("/%u.{4}|&#x.{4};|&#d+;|.+/U", $str, $r);
        $ar = $r[0];
        foreach($ar as $k => $v){
                if(substr($v, 0, 2) == '%u'){
                        if(function_exists('mb_convert_encoding')){
                                $ar[$k] = mb_convert_encoding(pack('H4', substr($v, -4)), strtoupper(IN_CHARSET), 'UCS-2');
                        }else{
                                $ar[$k] = iconv($code, strtoupper(IN_CHARSET).'//IGNORE', pack('H4', substr($v, -4)));
                        }
                }elseif(substr($v, 0, 3) == '&#x'){
                        if(function_exists('mb_convert_encoding')){
                                $ar[$k] = mb_convert_encoding(pack('H4', substr($v, 3, -1)), strtoupper(IN_CHARSET), 'UCS-2');
                        }else{
                                $ar[$k] = iconv($code, strtoupper(IN_CHARSET).'//IGNORE', pack('H4', substr($v, 3, -1)));
                        }
                }elseif(substr($v, 0, 2) == '&#'){
                        if(function_exists('mb_convert_encoding')){
                                $ar[$k] = mb_convert_encoding(pack('H4', substr($v, 2, -1)), strtoupper(IN_CHARSET), 'UCS-2');
                        }else{
                                $ar[$k] = iconv($code, strtoupper(IN_CHARSET).'//IGNORE', pack('H4', substr($v, 2, -1)));
                        }
                }
        }
        return SafeSql(implode('', $ar));
}
function SafeSql($key, $type=0){
	if($type){
		$array = explode(',', $key);
		for($i = 0; $i < count($array); $i++){
			$arr[] = intval($array[$i]);
		}
		return implode(',', $arr);
	}else{
		return htmlspecialchars(str_replace('\\', '', $key), ENT_QUOTES, set_chars(), false);
	}
}
function SafeRequest($key, $mode, $type=0){
	$magic = get_magic_quotes_gpc();
	switch($mode){
		case 'post':
			$value = isset($_POST[$key]) ? $magic ? trim($_POST[$key]) : addslashes(trim($_POST[$key])) : NULL;
			break;
		case 'get':
			$value = isset($_GET[$key]) ? $magic ? trim($_GET[$key]) : addslashes(trim($_GET[$key])) : NULL;
			break;
	}
	return $type ? $value : htmlspecialchars(str_replace('\\'.'\\', '', $value), ENT_QUOTES, set_chars(), false);
}
function RequestBox($key){
	$array = isset($_POST[$key]) ? $_POST[$key] : NULL;
	if(empty($array)){
		$value = 0;
	}else{
		for($i = 0; $i < count($array); $i++){
			$arr[] = intval($array[$i]);
		}
		$value = implode(',', $arr);
	}
	return $value;
}
function ReplaceStr($text, $search, $replace){
	$text = !empty($text) ? $text : NULL;
	$result = str_replace($search, $replace, $text);
	return $result;
}
function DateDiff($d1, $d2){
 	$first = is_string($d1) ? strtotime($d1) : $d1;
 	$last = is_string($d2) ? strtotime($d2) : $d2;
	$time = intval($last) - intval($first);
 	return $time;
}
function creatdir($dir){
	if(!is_dir($dir)){
		@mkdir($dir, 0777, true);
	}
}
function destroyDir($dir){
        $ds = DIRECTORY_SEPARATOR;
        $dir = substr($dir, -1) == $ds ? substr($dir, 0, -1) : $dir;
        if(is_dir($dir) && $handle = opendir($dir)){
                while($file = readdir($handle)){
                        if($file == '.' || $file == '..'){
                                continue;
                        }elseif(is_dir($dir.$ds.$file)){
                                destroyDir($dir.$ds.$file);
                        }else{
                                unlink($dir.$ds.$file);
                        }
                }
                closedir($handle);
                rmdir($dir);
        }
}
function SafeDel($table, $field, $id){
	global $db;
	$match = 'data\/attachment\/'.$table.'\/'.str_replace(array('in_cover', 'in_play', 'in_lyric', 'in_audio'), array('cover', 'play', 'lyric', 'audio'), $field).'\/';
	$file = strtolower($db->getone("select ".$field." from ".tname($table)." where in_id=".$id));
	$one = $db->getone("select in_id from ".tname($table)." where in_id<>".$id." and ".$field."='".$file."'");
	$one or !preg_match("/^".$match."\d/", $file) or @unlink(IN_ROOT.$file);
}
function checkrename($file, $dir, $old='', $mode='add', $table='', $field='', $id=0){
	$file = preg_match('/(\.\/|\?iframe=|.php\?|ucenter.php|config.inc.php)/i', $file) ? 'Safety filter' : $file;
	if($mode == 'add'){
		if(preg_match("/^data\/tmp\/\d/", $file)){
			$var = str_replace('tmp', $dir, $file);
			@rename(IN_ROOT.$file, IN_ROOT.$var);
			return $var;
		}else{
			return $file;
		}
	}else{
		if($file !== $old){
			SafeDel($table, $field, $id);
			if(preg_match("/^data\/tmp\/\d/", $file)){
			        $var = str_replace('tmp', $dir, $file);
			        @rename(IN_ROOT.$file, IN_ROOT.$var);
			        return $var;
			}else{
			        return $file;
			}
		}else{
			return $file;
		}
	}
}
function getpagerow($sqlstr, $pagesok){
	global $db;
	$url = $_SERVER['QUERY_STRING'];
	if(stristr($url, '&pages')){
		$url = preg_replace('/&pages=([\S]+?)$/', '', $url);
	}
	$page = intval(SafeRequest("pages","get"));
	$pages = $page <= 0 ? 1 : $page;
 	$nums = $db->num_rows($db->query(preg_replace('/^select \* from/i', 'select count(*) from', $sqlstr, 1)));
	$num = $nums == 0 ? 1 : $nums;
	$pagejs = ceil($num / $pagesok);
	if($pages > $pagejs){
		$pages = $pagejs;
	}
	$result = $db->query($sqlstr." LIMIT ".$pagesok * ($pages - 1).",".$pagesok);
 	$str = "<tr><td colspan=\"15\"><div class=\"cuspages right\"><div class=\"pg\"><em>&nbsp;".$nums."&nbsp;</em>";
	$str .= "<a href=\"?".$url."&pages=1\" class=\"prev\">首页</a>";
	if($pages > 1){
		$str .= "<a href=\"?".$url."&pages=".($pages - 1)."\" class=\"prev\">&lsaquo;&lsaquo;</a>";
	}
	if($pagejs <= 10){
  		for($i=1;$i<=$pagejs;$i++){
   			if($i == $pages){
   				$str .= "<strong>".$i."</strong>";
   			}else{
   				$str .= "<a href=\"?".$url."&pages=".$i."\">".$i."</a>";
   			}
 	 	}
	}else{
 		if($pages >= 12){
 			for($i=$pages-5;$i<=$pages+6;$i++){
   				if($i <= $pagejs){
   				        if($i == $pages){
   						$str .= "<strong>".$i."</strong>";
   				        }else{
   						$str .= "<a href=\"?".$url."&pages=".$i."\">".$i."</a>";
   				        }
    				}
  			}
  			if($i <= $pagejs){ 
    				$str .= "...";
	    			$str .= "<a href=\"?".$url."&pages=".$pagejs."\">".$pagejs."</a>";
   			}
   		}else{
  			for($i=1;$i<=12;$i++){
   				if($i == $pages){
   					$str .= "<strong>".$i."</strong>";
   				}else{
   					$str .= "<a href=\"?".$url."&pages=".$i."\">".$i."</a>";
   				}
 			}
 			if($i <= $pagejs){
      				$str .= "...";
	  			$str .= "<a href=\"?".$url."&pages=".$pagejs."\">".$pagejs."</a>";
    			}
 		 }
	}
	if($pages < $pagejs){
		$str .= "<a href=\"?".$url."&pages=".($pages + 1)."\" class=\"nxt\">&rsaquo;&rsaquo;</a>";
	}
	$str .= "<a href=\"?".$url."&pages=".$pagejs."\" class=\"nxt\">尾页</a>";
	$str .= "<em>&nbsp;".$pages."/".$pagejs."&nbsp;</em></div></div></td></tr>";
	$arr = array($str, $result, $nums);
	return $arr;
}
class iFile{
	private $Fp;
	private $File;
	private $OpenMode;
	function iFile($File, $Mode){
        	$this->File = $File;
        	$this->OpenMode = $Mode;
        	$this->OpenFile();
	}
	function OpenFile(){
        	$this->Fp = fopen($this->File, $this->OpenMode);
	}
	function CloseFile(){
        	fclose($this->Fp);
	}
	function WriteFile($Data4Write, $Mode){
        	flock($this->Fp, $Mode);
        	fwrite($this->Fp, $Data4Write);
        	$this->CloseFile();
	}
}
function html_message($title, $msg, $code=''){
        return "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=".IN_CHARSET."\" /><title>站点提示</title></head><body bgcolor=\"#FFFFFF\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"850\" align=\"center\" height=\"85%\"><tr align=\"center\" valign=\"middle\"><td><table cellpadding=\"20\" cellspacing=\"0\" border=\"0\" width=\"80%\" align=\"center\" style=\"font-family: Verdana, Tahoma; color: #666666; font-size: 12px\"><tr><td valign=\"middle\" align=\"center\" bgcolor=\"#EBEBEB\"><b style=\"font-size: 16px\">".$title."</b><br /><br /><p style=\"text-align:left;\">".$msg."</p><br /><br /></td></tr></table></td></tr></table>".$code."</body></html>";
}
function iframe_message($msg){
        return "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=".IN_CHARSET."\" /><table style=\"border:1px solid #09C\" align=\"center\"><tr><td><div style=\"text-align:center;color:#09C\">".$msg."</div></td></tr></table>";
}
function close_browse($msg='Access denied'){
        if(empty($_SERVER['HTTP_REFERER'])){
                exit($msg);
        }elseif(!preg_match("/^(http:\/\/".$_SERVER['HTTP_HOST'].")/i", $_SERVER['HTTP_REFERER'])){
                exit($msg);
        }
}
function core_entry($read){
	if(is_file($read)){
		include_once $read;
	}else{
		header('location:'.IN_PATH);
	}
}
function ergodic_array($str, $key){
	if(!empty($str)){
                $array = explode(',', $str);
                $result = false;
                for($i = 0; $i < count($array); $i++){
                        if($array[$i] == $key){$result = true;}
                }
        }else{
                $result = false;
	}
	return $result;
}
function convert_xmlcharset($str, $type=0){
	if($type == 1){
		return IN_CHARSET == 'utf-8' ? iconv('UTF-8', 'GBK//IGNORE', $str) : $str;
	}elseif($type == 2){
		return IN_CHARSET == 'gbk' ? iconv('GBK', 'UTF-8//IGNORE', $str) : $str;
	}else{
		return IN_CHARSET == 'gbk' ? iconv('UTF-8', 'GBK//IGNORE', $str) : $str;
	}
}
function convert_using($field){
	if(IN_CHARSET == 'utf-8'){
		return 'convert('.$field.' USING gbk)';
	}else{
		return $field;
	}
}
function set_chars(){
	return IN_CHARSET == 'gbk' ? 'GB2312' : 'UTF-8';
}
function rewrite_mode($para, $html=false){
	if(IN_REWRITEOPEN == 1){
		return IN_PATH.str_replace(array('.php/', '/]'), array('/', '.html'), $para.']');
	}elseif(!checkmobile() && $html && IN_REWRITEOPEN == 2){
		$arr = explode('/', $para);
		$table = $arr[1];
		$id = $arr[2];
		$pid = preg_match('/^p\d+$/', $arr[3]) ? str_replace('p', '', $arr[3]) : 1;
		if(in_array($table, array('music', 'special', 'singer', 'video', 'article'))){ //新增Article模块
                        return IN_PATH.$table.'/'.$id.'.html';
		}elseif(in_array($table, array('class', 'special_class', 'singer_class', 'video_class', 'article_class'))){ //新增Article模块
                        return IN_PATH.$table.'/'.$id.'/'.$pid.'.html';
		}else{
                        return IN_PATH.$para;
		}
	}else{
		return IN_PATH.$para;
	}
}
function submitcheck($var, $token=0){
	if($token < 0){
		return empty($_GET[$var]) || $_GET[$var] !== $_COOKIE['in_adminpassword'] ? false : true;
	}elseif(!empty($_POST[$var]) && $_SERVER['REQUEST_METHOD'] == 'POST'){
		if(empty($_SERVER['HTTP_REFERER']) || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])){
			return $token ? $_POST[$var] !== $_COOKIE['in_adminpassword'] ? false : true : true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}
function checkmobile(){
	global $_G;
	$mobile = array();
	static $touchbrowser_list = array('iphone', 'android', 'phone', 'mobile', 'wap', 'netfront', 'java', 'opera mobi', 'opera mini', 'ucweb', 'windows ce', 'symbian', 'series', 'webos', 'sony', 'blackberry', 'dopod', 'nokia', 'samsung', 'palmsource', 'xda', 'pieplus', 'meizu', 'midp', 'cldc', 'motorola', 'foma', 'docomo', 'up.browser', 'up.link', 'blazer', 'helio', 'hosin', 'huawei', 'novarra', 'coolpad', 'webos', 'techfaith', 'palmsource', 'alcatel', 'amoi', 'ktouch', 'nexian', 'ericsson', 'philips', 'sagem', 'wellcom', 'bunjalloo', 'maui', 'smartphone', 'iemobile', 'spice', 'bird', 'zte-', 'longcos', 'pantech', 'gionee', 'portalmmm', 'jig browser', 'hiptop', 'benq', 'haier', '^lct', '320x320', '240x320', '176x220', 'windows phone');
	static $wmlbrowser_list = array('cect', 'compal', 'ctl', 'lg', 'nec', 'tcl', 'alcatel', 'ericsson', 'bird', 'daxian', 'dbtel', 'eastcom', 'pantech', 'dopod', 'philips', 'haier', 'konka', 'kejian', 'lenovo', 'benq', 'mot', 'soutec', 'nokia', 'sagem', 'sgh', 'sed', 'capitel', 'panasonic', 'sonyericsson', 'sharp', 'amoi', 'panda', 'zte');
	static $pad_list = array('ipad');
	$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(dstrpos($useragent, $pad_list)){
		return false;
	}
	if(($v = dstrpos($useragent, $touchbrowser_list, true))){
		$_G['mobile'] = $v;
		return '2';
	}
	if(($v = dstrpos($useragent, $wmlbrowser_list))){
		$_G['mobile'] = $v;
		return '3';
	}
	$brower = array('mozilla', 'chrome', 'safari', 'opera', 'm3gate', 'winwap', 'openwave', 'myop');
	if(dstrpos($useragent, $brower)){return false;}
	$_G['mobile'] = 'unknown';
	if(isset($_G['mobiletpl'][$_GET['mobile']])){
		return true;
	}else{
		return false;
	}
}
function dstrpos($string, $arr, $returnvalue=false){
	if(empty($string)){return false;}
	foreach((array)$arr as $v){
		if(strpos($string, $v) !== false){
			$return = $returnvalue ? $v : true;
			return $return;
		}
	}
	return false;
}
function getonlineip($format=0){
	global $_SGLOBAL;
	if(empty($_SGLOBAL['onlineip'])){
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')){
			$onlineip = getenv('HTTP_CLIENT_IP');
		}elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')){
			$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		}elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')){
			$onlineip = getenv('REMOTE_ADDR');
		}elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')){
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
		$_SGLOBAL['onlineip'] = isset($onlineipmatches[0]) ? $onlineipmatches[0] : 'unknown';
	}
	if($format){
		$ips = explode('.', $_SGLOBAL['onlineip']);
		for($i=0;$i<3;$i++){
			$ips[$i] = intval($ips[$i]);
		}
		return sprintf('%03d%03d%03d', $ips[0], $ips[1], $ips[2]);
	}else{
		return $_SGLOBAL['onlineip'];
	}
}
function auth_codes($str, $mode='en', $key=''){
	if(empty($key)){
		return $mode == 'de' ? base64_decode($str) : base64_encode($str);
	}else{
		return $mode == 'de' ? base64_decode(str_replace(md5($key), '', $str)) : md5($key).base64_encode($str);
	}
}
function get_app(){
	global $db;
        $app = '<select onchange="window.open(this.options[this.selectedIndex].value);"><option value="'.IN_PATH.'">应用列表</option>';
        $query = $db->query("select * from ".tname('plugin')." where in_type=2 and in_isindex=1");
        while($row = $db->fetch_array($query)){
                $app .= '<option value="'.rewrite_mode('plugin.php/'.$row['in_dir'].'/index/').'">'.$row['in_name'].'</option>';
        }
        return $app.'</select>';
}
function get_template($mode=0){
	global $db;
	$template = $db->getone("select in_path from ".tname('template')." where in_default=1");
	$tempath = substr($template, 0, strrpos(str_replace('//', '', $template.'/'), '/') + 1);
	$temp = checkmobile() ? $tempath.'mobile/html/' : $template;
	$path = checkmobile() ? $tempath.'mobile/' : $tempath;
	if($mode == 1){
		return IN_PATH.$path;
	}elseif($mode == 2){
		return $path;
	}else{
		return IN_ROOT.$temp;
	}
}
function getfield($table, $target, $object, $search, $null=0){
	global $db;
	$sql = "select ".$target." from ".tname($table)." where ".$object."='".$search."'";
	if($one = $db->getone($sql)){
		$field = $one;
	}else{
		$field = $null;
	}
	return $field;
}
function inserttable($tablename, $insertsqlarr, $returnid=0, $replace=false, $silent=0){
	global $db;
	$insertkeysql = $insertvaluesql = $comma = '';
	foreach($insertsqlarr as $insert_key => $insert_value){
		$insertkeysql .= $comma.'`'.$insert_key.'`';
		$insertvaluesql .= $comma.'\''.$insert_value.'\'';
		$comma = ', ';
	}
	$method = $replace ? 'REPLACE' : 'INSERT';
	$db->query($method.' INTO '.tname($tablename).' ('.$insertkeysql.') VALUES ('.$insertvaluesql.')', $silent ? 'SILENT' : '');
	if($returnid && !$replace){
		return $db->insert_id();
	}
}
function updatetable($tablename, $setsqlarr, $wheresqlarr, $silent=0){
	global $db;
	$setsql = $comma = '';
	foreach($setsqlarr as $set_key => $set_value){
		$setsql .= $comma.'`'.$set_key.'`'.'=\''.$set_value.'\'';
		$comma = ', ';
	}
	$where = $comma = '';
	if(empty($wheresqlarr)){
		$where = '1';
	}elseif(is_array($wheresqlarr)){
		foreach($wheresqlarr as $key => $value){
			$where .= $comma.'`'.$key.'`'.'=\''.$value.'\'';
			$comma = ' AND ';
		}
	}else{
		$where = $wheresqlarr;
	}
	$db->query('UPDATE '.tname($tablename).' SET '.$setsql.' WHERE '.$where, $silent ? 'SILENT' : '');
}
?>