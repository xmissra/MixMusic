<?php
class Min{
	public static function G_lobal($static, $id=0){
	        $static = preg_replace_callback('/<!--\{require \'(.*?)\'\}-->/', create_function('$match', 'return @file_get_contents(get_template().$match[1]);'), $static);
	        $static = preg_replace_callback('/\{\$rewrite\[\'(.*?)\'\]\}/', create_function('$match', 'return rewrite_mode($match[1]);'), $static);
	        global $db;
	        $query = $db->query("select in_name,in_selflable from ".tname('label')." order by in_priority asc");
		while($row = $db->fetch_array($query)){
			$static = str_replace('<!--{label '.$row['in_name'].'}-->', base64_decode($row['in_selflable']), $static);
		}
	        $search = array('{$_G[\'app\']}', '{$_G[\'tempath\']}', '{$_G[\'host\']}', '{$_G[\'path\']}', '{$_G[\'charset\']}', '{$_G[\'name\']}', '{$_G[\'keywords\']}', '{$_G[\'description\']}', '{$_G[\'icp\']}', '{$_G[\'mail\']}', '{$_G[\'stat\']}');
	        $replace = array(get_app(), get_template(1), $_SERVER['HTTP_HOST'], IN_PATH, IN_CHARSET, IN_NAME, IN_KEYWORDS, IN_DESCRIPTION, IN_ICP, IN_MAIL, base64_decode(IN_STAT));
	        $static = str_replace($search, $replace, $static);
	        return self::T_able($static, $id);
	}
	public static function T_able($static, $id){
	        preg_match_all('/<!--\{loop ([\S]+)\s+(.*?)\}-->([\s\S]+?)<!--\{\/loop \1\}-->/', $static, $arr);
	        if(!empty($arr)){
		        for($i=0;$i<count($arr[0]);$i++){
			        $table = $arr[1][$i];
			        $para = $arr[2][$i];
			        $sql = self::S_ql($table, $para, $id);
			        global $db;
			        $result = $db->query($sql);
				$sort = 0;
				$content = '';
				while($row = $db->fetch_array($result)){
					$sort = $sort + 1;
					switch($table){
						case 'tag':
							$content .= self::T_ag($arr[0][$i], $arr[3][$i], $row, $sort);
							break;
						case 'class':
							$content .= self::C_lass($arr[0][$i], $arr[3][$i], $row, $sort);
							break;
						case 'music':
							$content .= self::M_usic($arr[0][$i], $arr[3][$i], $row, $sort);
							break;
						case 'special_class':
							$content .= self::S_pecialClass($arr[0][$i], $arr[3][$i], $row, $sort);
							break;
						case 'special':
							$content .= self::S_pecial($arr[0][$i], $arr[3][$i], $row, $sort);
							break;
						case 'singer_class':
							$content .= self::S_ingerClass($arr[0][$i], $arr[3][$i], $row, $sort);
							break;
						case 'singer':
							$content .= self::S_inger($arr[0][$i], $arr[3][$i], $row, $sort);
							break;
						case 'video_class':
							$content .= self::V_ideoClass($arr[0][$i], $arr[3][$i], $row, $sort);
							break;
						case 'video':
							$content .= self::V_ideo($arr[0][$i], $arr[3][$i], $row, $sort);
							break;
						//新增Article模块	
						case 'article_class':
							$content .= self::A_rticleClass($arr[0][$i], $arr[3][$i], $row, $sort);
							break;
						case 'article':
							$content .= self::A_rticle($arr[0][$i], $arr[3][$i], $row, $sort);
							break;
						case 'link':
							$content .= self::L_ink($arr[0][$i], $arr[3][$i], $row, $sort);
							break;
						case 'user':
							$content .= self::U_ser($arr[0][$i], $arr[3][$i], $row, $sort);
							break;
					}
				}
				$static = str_replace($arr[0][$i], $content, $static);
		        }
	        }
	        unset($arr);
	        return $static;
	}
	public static function T_ag($para, $data, $row, $sort=1){
	        preg_match_all('/\{\$tag\[\'\s*([0-9a-zA-Z]+)([\s]*[len]*)[=]??([0-9a-zA-Z]*)\'\]\}/', $para, $arr);
	        if(!empty($arr)){
		        for($i=0;$i<count($arr[0]);$i++){
			        switch($arr[1][$i]){
				        case 'i':
                                                $data = str_replace('{$tag[\'i\']}', $sort, $data);
                                                break;
				        case 'id':
                                                $data = str_replace('{$tag[\'id\']}', $row['in_id'], $data);
                                                break;
				        case 'title':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_title'], $arr[3][$i]), $data);
                                                break;
				        case 'link':
                                                $data = str_replace('{$tag[\'link\']}', getlink($row['in_id'], 'tag'), $data);
                                                break;
			        }
		        }
	        }
	        unset($arr);
	        return $data;
	}
	public static function C_lass($para, $data, $row, $sort=1){
	        preg_match_all('/\{\$class\[\'\s*([0-9a-zA-Z]+)([\s]*[len]*)[=]??([0-9a-zA-Z]*)\'\]\}/', $para, $arr);
	        if(!empty($arr)){
		        for($i=0;$i<count($arr[0]);$i++){
			        switch($arr[1][$i]){
				        case 'i':
                                                $data = str_replace('{$class[\'i\']}', $sort, $data);
                                                break;
				        case 'id':
                                                $data = str_replace('{$class[\'id\']}', $row['in_id'], $data);
                                                break;
				        case 'name':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_name'], $arr[3][$i]), $data);
                                                break;
				        case 'link':
                                                $data = str_replace('{$class[\'link\']}', getlink($row['in_id'], 'class'), $data);
                                                break;
			        }
		        }
	        }
	        unset($arr);
	        return $data;
	}
	public static function M_usic($para, $data, $row, $sort=1){
	        preg_match_all('/\{\$music\[\'\s*([0-9a-zA-Z]+)([\s]*[len|style|size]*)[=]??([\da-zA-Z\-\\\\:\s]*)\'\]\}/', $para, $arr);
	        if(!empty($arr)){
		        for($i=0;$i<count($arr[0]);$i++){
			        switch($arr[1][$i]){
				        case 'i':
                                                $data = str_replace('{$music[\'i\']}', $sort, $data);
                                                break;
				        case 'id':
                                                $data = str_replace('{$music[\'id\']}', $row['in_id'], $data);
                                                break;
				        case 'name':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_name'], $arr[3][$i]), $data);
                                                break;
				        case 'link':
                                                $data = str_replace('{$music[\'link\']}', getlink($row['in_id'], 'music'), $data);
                                                break;
				        case 'classname':
                                                $data = str_replace($arr[0][$i], getlenth(getfield('class', 'in_name', 'in_id', $row['in_classid']), $arr[3][$i]), $data);
                                                break;
				        case 'classlink':
                                                $data = str_replace('{$music[\'classlink\']}', getlink($row['in_classid'], 'class'), $data);
                                                break;
				        case 'specialname':
                                                $data = str_replace($arr[0][$i], getlenth(getfield('special', 'in_name', 'in_id', $row['in_specialid'], '未知专辑'), $arr[3][$i]), $data);
                                                break;
				        case 'speciallink':
                                                $data = str_replace('{$music[\'speciallink\']}', getlink($row['in_specialid'], 'special'), $data);
                                                break;
				        case 'specialcover':
                                                $data = str_replace('{$music[\'specialcover\']}', geturl(getfield('special', 'in_cover', 'in_id', $row['in_specialid']), 'cover'), $data);
                                                break;
				        case 'singername':
                                                $data = str_replace($arr[0][$i], getlenth(getfield('singer', 'in_name', 'in_id', $row['in_singerid'], '未知歌手'), $arr[3][$i]), $data);
                                                break;
				        case 'singerlink':
                                                $data = str_replace('{$music[\'singerlink\']}', getlink($row['in_singerid'], 'singer'), $data);
                                                break;
				        case 'singercover':
                                                $data = str_replace('{$music[\'singercover\']}', geturl(getfield('singer', 'in_cover', 'in_id', $row['in_singerid']), 'cover'), $data);
                                                break;
				        case 'uname':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_uname'], $arr[3][$i]), $data);
                                                break;
				        case 'ulink':
                                                $data = str_replace('{$music[\'ulink\']}', getlink($row['in_uid']), $data);
                                                break;
				        case 'uavatar':
                                                $data = str_replace($arr[0][$i], getavatar($row['in_uid'], $arr[3][$i]), $data);
                                                break;
				        case 'audio':
                                                $data = str_replace('{$music[\'audio\']}', geturl($row['in_audio']), $data);
                                                break;
				        case 'lyric':
                                                $data = str_replace('{$music[\'lyric\']}', geturl($row['in_lyric'], 'lyric'), $data);
                                                break;
				        case 'cover':
                                                $data = str_replace('{$music[\'cover\']}', geturl($row['in_cover'], 'cover'), $data);
                                                break;
				        case 'tag':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_tag'], $arr[3][$i]), $data);
                                                break;
				        case 'color':
                                                $data = str_replace('{$music[\'color\']}', $row['in_color'], $data);
                                                break;
				        case 'hits':
                                                $data = str_replace('{$music[\'hits\']}', $row['in_hits'], $data);
                                                break;
				        case 'downhits':
                                                $data = str_replace('{$music[\'downhits\']}', $row['in_downhits'], $data);
                                                break;
				        case 'favhits':
                                                $data = str_replace('{$music[\'favhits\']}', $row['in_favhits'], $data);
                                                break;
				        case 'goodhits':
                                                $data = str_replace('{$music[\'goodhits\']}', $row['in_goodhits'], $data);
                                                break;
				        case 'badhits':
                                                $data = str_replace('{$music[\'badhits\']}', $row['in_badhits'], $data);
                                                break;
				        case 'points':
                                                $data = str_replace('{$music[\'points\']}', $row['in_points'], $data);
                                                break;
				        case 'grade':
                                                $data = str_replace('{$music[\'grade\']}', $row['in_grade'], $data);
                                                break;
				        case 'best':
                                                $data = str_replace('{$music[\'best\']}', $row['in_best'], $data);
                                                break;
				        case 'text':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_text'], $arr[3][$i]), $data);
                                                break;
				        case 'texts':
                                                $data = str_replace('{$music[\'texts\']}', nl2br($row['in_text']), $data);
                                                break;
				        case 'addtime':
                                                $data = str_replace($arr[0][$i], date($arr[3][$i], strtotime($row['in_addtime'])), $data);
                                                break;
			        }
		        }
	        }
	        unset($arr);
	        return $data;
	}
	public static function S_pecialClass($para, $data, $row, $sort=1){
	        preg_match_all('/\{\$specialclass\[\'\s*([0-9a-zA-Z]+)([\s]*[len]*)[=]??([0-9a-zA-Z]*)\'\]\}/', $para, $arr);
	        if(!empty($arr)){
		        for($i=0;$i<count($arr[0]);$i++){
			        switch($arr[1][$i]){
				        case 'i':
                                                $data = str_replace('{$specialclass[\'i\']}', $sort, $data);
                                                break;
				        case 'id':
                                                $data = str_replace('{$specialclass[\'id\']}', $row['in_id'], $data);
                                                break;
				        case 'name':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_name'], $arr[3][$i]), $data);
                                                break;
				        case 'link':
                                                $data = str_replace('{$specialclass[\'link\']}', getlink($row['in_id'], 'specialclass'), $data);
                                                break;
			        }
		        }
	        }
	        unset($arr);
	        return $data;
	}
	public static function S_pecial($para, $data, $row, $sort=1){
	        preg_match_all('/\{\$special\[\'\s*([0-9a-zA-Z]+)([\s]*[len|style|size]*)[=]??([\da-zA-Z\-\\\\:\s]*)\'\]\}/', $para, $arr);
	        if(!empty($arr)){
		        for($i=0;$i<count($arr[0]);$i++){
			        switch($arr[1][$i]){
				        case 'i':
                                                $data = str_replace('{$special[\'i\']}', $sort, $data);
                                                break;
				        case 'id':
                                                $data = str_replace('{$special[\'id\']}', $row['in_id'], $data);
                                                break;
				        case 'name':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_name'], $arr[3][$i]), $data);
                                                break;
				        case 'link':
                                                $data = str_replace('{$special[\'link\']}', getlink($row['in_id'], 'special'), $data);
                                                break;
				        case 'classname':
                                                $data = str_replace($arr[0][$i], getlenth(getfield('special_class', 'in_name', 'in_id', $row['in_classid']), $arr[3][$i]), $data);
                                                break;
				        case 'classlink':
                                                $data = str_replace('{$special[\'classlink\']}', getlink($row['in_classid'], 'specialclass'), $data);
                                                break;
				        case 'singername':
                                                $data = str_replace($arr[0][$i], getlenth(getfield('singer', 'in_name', 'in_id', $row['in_singerid'], '未知歌手'), $arr[3][$i]), $data);
                                                break;
				        case 'singerlink':
                                                $data = str_replace('{$special[\'singerlink\']}', getlink($row['in_singerid'], 'singer'), $data);
                                                break;
				        case 'singercover':
                                                $data = str_replace('{$special[\'singercover\']}', geturl(getfield('singer', 'in_cover', 'in_id', $row['in_singerid']), 'cover'), $data);
                                                break;
				        case 'uname':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_uname'], $arr[3][$i]), $data);
                                                break;
				        case 'ulink':
                                                $data = str_replace('{$special[\'ulink\']}', getlink($row['in_uid']), $data);
                                                break;
				        case 'uavatar':
                                                $data = str_replace($arr[0][$i], getavatar($row['in_uid'], $arr[3][$i]), $data);
                                                break;
				        case 'cover':
                                                $data = str_replace('{$special[\'cover\']}', geturl($row['in_cover'], 'cover'), $data);
                                                break;
				        case 'hits':
                                                $data = str_replace('{$special[\'hits\']}', $row['in_hits'], $data);
                                                break;
				        case 'firm':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_firm'], $arr[3][$i]), $data);
                                                break;
				        case 'lang':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_lang'], $arr[3][$i]), $data);
                                                break;
				        case 'intro':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_intro'], $arr[3][$i]), $data);
                                                break;
				        case 'intros':
                                                $data = str_replace('{$special[\'intros\']}', nl2br($row['in_intro']), $data);
                                                break;
				        case 'addtime':
                                                $data = str_replace($arr[0][$i], date($arr[3][$i], strtotime($row['in_addtime'])), $data);
                                                break;
			        }
		        }
	        }
	        unset($arr);
	        return $data;
	}
	public static function S_ingerClass($para, $data, $row, $sort=1){
	        preg_match_all('/\{\$singerclass\[\'\s*([0-9a-zA-Z]+)([\s]*[len]*)[=]??([0-9a-zA-Z]*)\'\]\}/', $para, $arr);
	        if(!empty($arr)){
		        for($i=0;$i<count($arr[0]);$i++){
			        switch($arr[1][$i]){
				        case 'i':
                                                $data = str_replace('{$singerclass[\'i\']}', $sort, $data);
                                                break;
				        case 'id':
                                                $data = str_replace('{$singerclass[\'id\']}', $row['in_id'], $data);
                                                break;
				        case 'name':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_name'], $arr[3][$i]), $data);
                                                break;
				        case 'link':
                                                $data = str_replace('{$singerclass[\'link\']}', getlink($row['in_id'], 'singerclass'), $data);
                                                break;
			        }
		        }
	        }
	        unset($arr);
	        return $data;
	}
	public static function S_inger($para, $data, $row, $sort=1){
	        preg_match_all('/\{\$singer\[\'\s*([0-9a-zA-Z]+)([\s]*[len|style|size]*)[=]??([\da-zA-Z\-\\\\:\s]*)\'\]\}/', $para, $arr);
	        if(!empty($arr)){
		        for($i=0;$i<count($arr[0]);$i++){
			        switch($arr[1][$i]){
				        case 'i':
                                                $data = str_replace('{$singer[\'i\']}', $sort, $data);
                                                break;
				        case 'id':
                                                $data = str_replace('{$singer[\'id\']}', $row['in_id'], $data);
                                                break;
				        case 'name':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_name'], $arr[3][$i]), $data);
                                                break;
				        case 'nick':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_nick'], $arr[3][$i]), $data);
                                                break;
				        case 'link':
                                                $data = str_replace('{$singer[\'link\']}', getlink($row['in_id'], 'singer'), $data);
                                                break;
				        case 'classname':
                                                $data = str_replace($arr[0][$i], getlenth(getfield('singer_class', 'in_name', 'in_id', $row['in_classid']), $arr[3][$i]), $data);
                                                break;
				        case 'classlink':
                                                $data = str_replace('{$singer[\'classlink\']}', getlink($row['in_classid'], 'singerclass'), $data);
                                                break;
				        case 'uname':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_uname'], $arr[3][$i]), $data);
                                                break;
				        case 'ulink':
                                                $data = str_replace('{$singer[\'ulink\']}', getlink($row['in_uid']), $data);
                                                break;
				        case 'uavatar':
                                                $data = str_replace($arr[0][$i], getavatar($row['in_uid'], $arr[3][$i]), $data);
                                                break;
				        case 'cover':
                                                $data = str_replace('{$singer[\'cover\']}', geturl($row['in_cover'], 'cover'), $data);
                                                break;
				        case 'hits':
                                                $data = str_replace('{$singer[\'hits\']}', $row['in_hits'], $data);
                                                break;
				        case 'intro':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_intro'], $arr[3][$i]), $data);
                                                break;
				        case 'intros':
                                                $data = str_replace('{$singer[\'intros\']}', nl2br($row['in_intro']), $data);
                                                break;
				        case 'addtime':
                                                $data = str_replace($arr[0][$i], date($arr[3][$i], strtotime($row['in_addtime'])), $data);
                                                break;
			        }
		        }
	        }
	        unset($arr);
	        return $data;
	}
	public static function V_ideoClass($para, $data, $row, $sort=1){
	        preg_match_all('/\{\$videoclass\[\'\s*([0-9a-zA-Z]+)([\s]*[len]*)[=]??([0-9a-zA-Z]*)\'\]\}/', $para, $arr);
	        if(!empty($arr)){
		        for($i=0;$i<count($arr[0]);$i++){
			        switch($arr[1][$i]){
				        case 'i':
                                                $data = str_replace('{$videoclass[\'i\']}', $sort, $data);
                                                break;
				        case 'id':
                                                $data = str_replace('{$videoclass[\'id\']}', $row['in_id'], $data);
                                                break;
				        case 'name':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_name'], $arr[3][$i]), $data);
                                                break;
				        case 'link':
                                                $data = str_replace('{$videoclass[\'link\']}', getlink($row['in_id'], 'videoclass'), $data);
                                                break;
			        }
		        }
	        }
	        unset($arr);
	        return $data;
	}
	public static function V_ideo($para, $data, $row, $sort=1){
	        preg_match_all('/\{\$video\[\'\s*([0-9a-zA-Z]+)([\s]*[len|style|size]*)[=]??([\da-zA-Z\-\\\\:\s]*)\'\]\}/', $para, $arr);
	        if(!empty($arr)){
		        for($i=0;$i<count($arr[0]);$i++){
			        switch($arr[1][$i]){
				        case 'i':
                                                $data = str_replace('{$video[\'i\']}', $sort, $data);
                                                break;
				        case 'id':
                                                $data = str_replace('{$video[\'id\']}', $row['in_id'], $data);
                                                break;
				        case 'name':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_name'], $arr[3][$i]), $data);
                                                break;
				        case 'link':
                                                $data = str_replace('{$video[\'link\']}', getlink($row['in_id'], 'video'), $data);
                                                break;
				        case 'classname':
                                                $data = str_replace($arr[0][$i], getlenth(getfield('video_class', 'in_name', 'in_id', $row['in_classid']), $arr[3][$i]), $data);
                                                break;
				        case 'classlink':
                                                $data = str_replace('{$video[\'classlink\']}', getlink($row['in_classid'], 'videoclass'), $data);
                                                break;
				        case 'singername':
                                                $data = str_replace($arr[0][$i], getlenth(getfield('singer', 'in_name', 'in_id', $row['in_singerid'], '未知歌手'), $arr[3][$i]), $data);
                                                break;
				        case 'singerlink':
                                                $data = str_replace('{$video[\'singerlink\']}', getlink($row['in_singerid'], 'singer'), $data);
                                                break;
				        case 'singercover':
                                                $data = str_replace('{$video[\'singercover\']}', geturl(getfield('singer', 'in_cover', 'in_id', $row['in_singerid']), 'cover'), $data);
                                                break;
				        case 'uname':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_uname'], $arr[3][$i]), $data);
                                                break;
				        case 'ulink':
                                                $data = str_replace('{$video[\'ulink\']}', getlink($row['in_uid']), $data);
                                                break;
				        case 'uavatar':
                                                $data = str_replace($arr[0][$i], getavatar($row['in_uid'], $arr[3][$i]), $data);
                                                break;
				        case 'play':
                                                $data = str_replace('{$video[\'play\']}', geturl($row['in_play']), $data);
                                                break;
				        case 'cover':
                                                $data = str_replace('{$video[\'cover\']}', geturl($row['in_cover'], 'cover'), $data);
                                                break;
				        case 'hits':
                                                $data = str_replace('{$video[\'hits\']}', $row['in_hits'], $data);
                                                break;
				        case 'intro':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_intro'], $arr[3][$i]), $data);
                                                break;
				        case 'intros':
                                                $data = str_replace('{$video[\'intros\']}', nl2br($row['in_intro']), $data);
                                                break;
				        case 'addtime':
                                                $data = str_replace($arr[0][$i], date($arr[3][$i], strtotime($row['in_addtime'])), $data);
                                                break;
			        }
		        }
	        }
	        unset($arr);
	        return $data;
	}

	//新增Article模块
	public static function A_rticleClass($para, $data, $row, $sort=1){
	        preg_match_all('/\{\$articleclass\[\'\s*([0-9a-zA-Z]+)([\s]*[len]*)[=]??([0-9a-zA-Z]*)\'\]\}/', $para, $arr);
	        if(!empty($arr)){
		        for($i=0;$i<count($arr[0]);$i++){
			        switch($arr[1][$i]){
				        case 'i':
							$data = str_replace('{$articleclass[\'i\']}', $sort, $data);
							break;
				        case 'id':
							$data = str_replace('{$articleclass[\'id\']}', $row['in_id'], $data);
							break;
				        case 'name':
							$data = str_replace($arr[0][$i], getlenth($row['in_name'], $arr[3][$i]), $data);
							break;
				        case 'link':
							$data = str_replace('{$articleclass[\'link\']}', getlink($row['in_id'], 'articleclass'), $data);
							break;
			        }
		        }
	        }
	        unset($arr);
	        return $data;
	}

	//新增Article模块
	public static function A_rticle($para, $data, $row, $sort=1){
	        preg_match_all('/\{\$article\[\'\s*([0-9a-zA-Z]+)([\s]*[len|style|size]*)[=]??([\da-zA-Z\-\\\\:\s]*)\'\]\}/', $para, $arr);
	        if(!empty($arr)){
		        for($i=0;$i<count($arr[0]);$i++){
			        switch($arr[1][$i]){
				        case 'i':
							$data = str_replace('{$article[\'i\']}', $sort, $data);
							break;
				        case 'id':
							$data = str_replace('{$article[\'id\']}', $row['in_id'], $data);
							break;
				        case 'name':
							$data = str_replace($arr[0][$i], getlenth($row['in_name'], $arr[3][$i]), $data);
							break;
				        case 'nick':
							$data = str_replace($arr[0][$i], getlenth($row['in_nick'], $arr[3][$i]), $data);
							break;
				        case 'link':
							$data = str_replace('{$article[\'link\']}', getlink($row['in_id'], 'article'), $data);
							break;
				        case 'classname':
							$data = str_replace($arr[0][$i], getlenth(getfield('article_class', 'in_name', 'in_id', $row['in_classid']), $arr[3][$i]), $data);
							break;
				        case 'classlink':
							$data = str_replace('{$article[\'classlink\']}', getlink($row['in_classid'], 'articleclass'), $data);
							break;
				        case 'uname':
							$data = str_replace($arr[0][$i], getlenth($row['in_uname'], $arr[3][$i]), $data);
							break;
				        case 'ulink':
							$data = str_replace('{$article[\'ulink\']}', getlink($row['in_uid']), $data);
							break;
				        case 'uavatar':
							$data = str_replace($arr[0][$i], getavatar($row['in_uid'], $arr[3][$i]), $data);
							break;
				        case 'cover':
							$data = str_replace('{$article[\'cover\']}', geturl($row['in_cover'], 'cover'), $data);
							break;
				        case 'hits':
							$data = str_replace('{$article[\'hits\']}', $row['in_hits'], $data);
							break;
				        case 'intro':
							$data = str_replace($arr[0][$i], getlenth($row['in_intro'], $arr[3][$i]), $data);
							break;
				        case 'intros':
							$data = str_replace('{$article[\'intros\']}', nl2br($row['in_intro']), $data);
							break;
				        case 'addtime':
							$data = str_replace($arr[0][$i], date($arr[3][$i], strtotime($row['in_addtime'])), $data);
							break;
			        }
		        }
	        }
	        unset($arr);
	        return $data;
	}	

	public static function L_ink($para, $data, $row, $sort=1){
	        preg_match_all('/\{\$link\[\'\s*([0-9a-zA-Z]+)([\s]*[len]*)[=]??([0-9a-zA-Z]*)\'\]\}/', $para, $arr);
	        if(!empty($arr)){
		        for($i=0;$i<count($arr[0]);$i++){
			        switch($arr[1][$i]){
				        case 'i':
                                                $data = str_replace('{$link[\'i\']}', $sort, $data);
                                                break;
				        case 'id':
                                                $data = str_replace('{$link[\'id\']}', $row['in_id'], $data);
                                                break;
				        case 'name':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_name'], $arr[3][$i]), $data);
                                                break;
				        case 'url':
                                                $data = str_replace('{$link[\'url\']}', $row['in_url'], $data);
                                                break;
				        case 'cover':
                                                $data = str_replace('{$link[\'cover\']}', geturl($row['in_cover'], 'cover'), $data);
                                                break;
			        }
		        }
	        }
	        unset($arr);
	        return $data;
	}
	public static function U_ser($para, $data, $row, $sort=1){
	        preg_match_all('/\{\$user\[\'\s*([0-9a-zA-Z]+)([\s]*[len|style|size]*)[=]??([\da-zA-Z\-\\\\:\s]*)\'\]\}/', $para, $arr);
	        if(!empty($arr)){
		        for($i=0;$i<count($arr[0]);$i++){
			        switch($arr[1][$i]){
				        case 'i':
                                                $data = str_replace('{$user[\'i\']}', $sort, $data);
                                                break;
				        case 'id':
                                                $data = str_replace('{$user[\'id\']}', $row['in_userid'], $data);
                                                break;
				        case 'name':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_username'], $arr[3][$i]), $data);
                                                break;
				        case 'link':
                                                $data = str_replace('{$user[\'link\']}', getlink($row['in_userid']), $data);
                                                break;
				        case 'avatar':
                                                $data = str_replace($arr[0][$i], getavatar($row['in_userid'], $arr[3][$i]), $data);
                                                break;
				        case 'sex':
                                                $data = str_replace('{$user[\'sex\']}', getsex($row['in_sex']), $data);
                                                break;
				        case 'mail':
                                                $data = str_replace('{$user[\'mail\']}', $row['in_mail'], $data);
                                                break;
				        case 'birthday':
                                                $data = str_replace('{$user[\'birthday\']}', $row['in_birthday'], $data);
                                                break;
				        case 'address':
                                                $data = str_replace('{$user[\'address\']}', $row['in_address'], $data);
                                                break;
				        case 'hits':
                                                $data = str_replace('{$user[\'hits\']}', $row['in_hits'], $data);
                                                break;
				        case 'points':
                                                $data = str_replace('{$user[\'points\']}', $row['in_points'], $data);
                                                break;
				        case 'rank':
                                                $data = str_replace('{$user[\'rank\']}', $row['in_rank'], $data);
                                                break;
				        case 'isstar':
                                                $data = str_replace('{$user[\'isstar\']}', $row['in_isstar'], $data);
                                                break;
				        case 'grade':
                                                $data = str_replace('{$user[\'grade\']}', $row['in_grade'], $data);
                                                break;
				        case 'introduce':
                                                $data = str_replace($arr[0][$i], getlenth($row['in_introduce'], $arr[3][$i]), $data);
                                                break;
				        case 'regdate':
                                                $data = str_replace($arr[0][$i], date($arr[3][$i], strtotime($row['in_regdate'])), $data);
                                                break;
				        case 'logintime':
                                                $data = str_replace($arr[0][$i], date($arr[3][$i], strtotime($row['in_logintime'])), $data);
                                                break;
			        }
		        }
	        }
	        unset($arr);
	        return $data;
	}
	public static function S_ql($table, $para, $id){
	        $sql = "select * from ".tname($table);
	        preg_match_all('/([a-z0-9]+)=([a-z0-9|,]+)/', $para, $arr);
	        if(!empty($arr)){
		        $class = '';
		        $special = '';
		        $singer = '';
				//新增Article模块
				$article = '';
		        $best = '';
		        $type = '';
		        $mode = '';
		        $sort = '';
		        $order = '';
		        $start = '';
		        $count = '';
		        for($i=0;$i<count($arr[0]);$i++){
			        switch($arr[1][$i]){
				        case 'class':
					        $class = $arr[2][$i];
					        break;
				        case 'special':
					        $special = $arr[2][$i];
					        break;
				        case 'singer':
					        $singer = $arr[2][$i];
					        break;
						//新增Article模块	
						case 'article':
					        $article = $arr[2][$i];
					        break;
				        case 'best':
					        $best = $arr[2][$i];
					        break;
				        case 'type':
					        $type = $arr[2][$i];
					        break;
				        case 'mode':
					        $mode = $arr[2][$i];
					        break;
				        case 'sort':
					        $sort = $arr[2][$i];
					        break;
				        case 'order':
					        $order = $arr[2][$i];
					        break;
				        case 'start':
					        $start = $arr[2][$i];
					        break;
				        case 'count':
					        $count = $arr[2][$i];
					        break;
			        }
		        }
		        $sql = $sql." where";
		        if($order !== 'asc'){
			        $order = "desc";
		        }
		        if(!is_numeric($start)){
			        $start = 1;
		        }
		        switch($table){
			        case 'tag':
				        if($sort == 'rand'){
					        $sort = "rand()";
				        }else{
					        $sort = "in_id";
				        }
				        $sql .= " in_type=".intval($type)." order by ".$sort." ".$order;
				        if(is_numeric($count)){
					        $sql .= " LIMIT ".($start-1).",".$count;
				        }
				        break;
			        case 'class':
				        if($sort == 'rand'){
					        $sort = "rand()";
				        }elseif($sort == 'id'){
					        $sort = "in_id";
				        }else{
					        $sort = "in_order";
				        }
				        $sql .= " in_hide=0 order by ".$sort." ".$order;
				        if(is_numeric($count)){
					        $sql .= " LIMIT ".($start-1).",".$count;
				        }
				        break;
			        case 'music':
				        if($sort == 'rand'){
					        $sort = "rand()";
				        }elseif($sort == 'id'){
					        $sort = "in_id";
				        }elseif($sort == 'hits'){
					        $sort = "in_hits";
				        }elseif($sort == 'downhits'){
					        $sort = "in_downhits";
					        $sql .= " in_downhits>0 and";
				        }elseif($sort == 'favhits'){
					        $sort = "in_favhits";
					        $sql .= " in_favhits>0 and";
				        }elseif($sort == 'goodhits'){
					        $sort = "in_goodhits";
					        $sql .= " in_goodhits>0 and";
				        }elseif($sort == 'badhits'){
					        $sort = "in_badhits";
					        $sql .= " in_badhits>0 and";
				        }elseif($sort == 'best'){
					        $sort = "in_best";
					        $sql .= " in_best>0 and";
				        }else{
					        $sort = "UNIX_TIMESTAMP(in_addtime)";
				        }
				        if($class == 'auto'){
					        $sql .= " in_classid in (".getfield($table, 'in_classid', 'in_id', $id).") and";
				        }elseif($class == 'this'){
					        $sql .= " in_classid in ($id) and";
				        }elseif($special == 'this'){
					        $sql .= " in_specialid in ($id) and";
				        }elseif($singer == 'this'){
					        $sql .= " in_singerid in ($id) and";
				        }
				        if(!empty($best)){
					        $sql .= " in_best in ($best) and";
				        }
				        $sql .= " in_passed=0 order by ".$sort." ".$order;
				        if(is_numeric($count)){
					        $sql .= " LIMIT ".($start-1).",".$count;
				        }
				        break;
			        case 'special_class':
				        if($sort == 'rand'){
					        $sort = "rand()";
				        }elseif($sort == 'id'){
					        $sort = "in_id";
				        }else{
					        $sort = "in_order";
				        }
				        $sql .= " in_hide=0 order by ".$sort." ".$order;
				        if(is_numeric($count)){
					        $sql .= " LIMIT ".($start-1).",".$count;
				        }
				        break;
			        case 'special':
				        if($sort == 'rand'){
					        $sort = "rand()";
				        }elseif($sort == 'id'){
					        $sort = "in_id";
				        }elseif($sort == 'hits'){
					        $sort = "in_hits";
				        }else{
					        $sort = "UNIX_TIMESTAMP(in_addtime)";
				        }
				        if($class == 'auto'){
					        $sql .= " in_classid in (".getfield($table, 'in_classid', 'in_id', $id).") and";
				        }elseif($class == 'this'){
					        $sql .= " in_classid in ($id) and";
				        }elseif($singer == 'this'){
					        $sql .= " in_singerid in ($id) and";
				        }
				        $sql .= " in_passed=0 order by ".$sort." ".$order;
				        if(is_numeric($count)){
					        $sql .= " LIMIT ".($start-1).",".$count;
				        }
				        break;
			        case 'singer_class':
				        if($sort == 'rand'){
					        $sort = "rand()";
				        }elseif($sort == 'id'){
					        $sort = "in_id";
				        }else{
					        $sort = "in_order";
				        }
				        $sql .= " in_hide=0 order by ".$sort." ".$order;
				        if(is_numeric($count)){
					        $sql .= " LIMIT ".($start-1).",".$count;
				        }
				        break;
			        case 'singer':
				        if($sort == 'rand'){
					        $sort = "rand()";
				        }elseif($sort == 'id'){
					        $sort = "in_id";
				        }elseif($sort == 'hits'){
					        $sort = "in_hits";
				        }else{
					        $sort = "UNIX_TIMESTAMP(in_addtime)";
				        }
				        if($class == 'auto'){
					        $sql .= " in_classid in (".getfield($table, 'in_classid', 'in_id', $id).") and";
				        }elseif($class == 'this'){
					        $sql .= " in_classid in ($id) and";
				        }
				        $sql .= " in_passed=0 order by ".$sort." ".$order;
				        if(is_numeric($count)){
					        $sql .= " LIMIT ".($start-1).",".$count;
				        }
				        break;
			        case 'video_class':
				        if($sort == 'rand'){
					        $sort = "rand()";
				        }elseif($sort == 'id'){
					        $sort = "in_id";
				        }else{
					        $sort = "in_order";
				        }
				        $sql .= " in_hide=0 order by ".$sort." ".$order;
				        if(is_numeric($count)){
					        $sql .= " LIMIT ".($start-1).",".$count;
				        }
				        break;
			        case 'video':
				        if($sort == 'rand'){
					        $sort = "rand()";
				        }elseif($sort == 'id'){
					        $sort = "in_id";
				        }elseif($sort == 'hits'){
					        $sort = "in_hits";
				        }else{
					        $sort = "UNIX_TIMESTAMP(in_addtime)";
				        }
				        if($class == 'auto'){
					        $sql .= " in_classid in (".getfield($table, 'in_classid', 'in_id', $id).") and";
				        }elseif($class == 'this'){
					        $sql .= " in_classid in ($id) and";
				        }elseif($singer == 'this'){
					        $sql .= " in_singerid in ($id) and";
				        }
				        $sql .= " in_passed=0 order by ".$sort." ".$order;
				        if(is_numeric($count)){
					        $sql .= " LIMIT ".($start-1).",".$count;
				        }
				        break;

					//新增Article模块	
			        case 'article_class':
				        if($sort == 'rand'){
					        $sort = "rand()";
				        }elseif($sort == 'id'){
					        $sort = "in_id";
				        }else{
					        $sort = "in_order";
				        }
				        $sql .= " in_hide=0 order by ".$sort." ".$order;
				        if(is_numeric($count)){
					        $sql .= " LIMIT ".($start-1).",".$count;
				        }
				        break;

					//新增Article模块	
			        case 'article':
				        if($sort == 'rand'){
					        $sort = "rand()";
				        }elseif($sort == 'id'){
					        $sort = "in_id";
				        }elseif($sort == 'hits'){
					        $sort = "in_hits";
				        }else{
					        $sort = "UNIX_TIMESTAMP(in_addtime)";
				        }
				        if($class == 'auto'){
					        $sql .= " in_classid in (".getfield($table, 'in_classid', 'in_id', $id).") and";
				        }elseif($class == 'this'){
					        $sql .= " in_classid in ($id) and";
				        }
				        $sql .= " in_passed=0 order by ".$sort." ".$order;
				        if(is_numeric($count)){
					        $sql .= " LIMIT ".($start-1).",".$count;
				        }
				        break;
			        case 'link':
				        if($sort == 'rand'){
					        $sort = "rand()";
				        }elseif($sort == 'id'){
					        $sort = "in_id";
				        }else{
					        $sort = "in_order";
				        }
				        if(is_numeric($type)){
					        $sql .= " in_type=".$type." and in_hide=0 order by ".$sort." ".$order;
				        }else{
					        $sql .= " in_hide=0 order by ".$sort." ".$order;
				        }
				        if(is_numeric($count)){
					        $sql .= " LIMIT ".($start-1).",".$count;
				        }
				        break;
			        case 'user':
				        if($sort == 'rand'){
					        $sort = "rand()";
				        }elseif($sort == 'id'){
					        $sort = "in_userid";
				        }elseif($sort == 'hits'){
					        $sort = "in_hits";
				        }elseif($sort == 'points'){
					        $sort = "in_points";
				        }elseif($sort == 'rank'){
					        $sort = "in_rank";
				        }elseif($sort == 'login'){
					        $sort = "UNIX_TIMESTAMP(in_logintime)";
				        }else{
					        $sort = "UNIX_TIMESTAMP(in_regdate)";
				        }
				        if($mode == 'vip'){
					        $sql .= " in_grade=1 and";
				        }elseif($mode == 'star'){
					        $sql .= " in_isstar=1 and";
				        }elseif($mode == 'man'){
					        $sql .= " in_sex=0 and";
				        }elseif($mode == 'woman'){
					        $sql .= " in_sex=1 and";
				        }
				        $sql .= " in_islock=0 order by ".$sort." ".$order;
				        if(is_numeric($count)){
					        $sql .= " LIMIT ".($start-1).",".$count;
				        }
				        break;
		        }
	        }
	        unset($arr);
	        return $sql;
	}
}
?>