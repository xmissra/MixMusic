<?php
include 'source/system/db.class.php';
include 'source/system/cache.class.php';
include 'source/system/user.php';
include 'source/system/min.static.class.php';
include 'source/system/lib.static.class.php';
global $cache;
$array = array('class', 'music', 'special_class', 'special', 'singer_class', 'singer', 'video_class', 'video', 'article_class', 'article',/*新增Article模块*/ 'search', 'page', 'misc');
$index = explode('/', isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : NULL);
$table = isset($index[1]) ? $index[1] : NULL;
if (in_array($table, $array)) {
    if ($table == 'misc') {
        $do = isset($index[2]) ? $index[2] : NULL;
        core_entry(get_template(2) . 'misc/' . $do . '.php');
    } elseif ($table == 'page') {
        $page = isset($index[2]) ? $index[2] : NULL;
        is_file(get_template() . $page . '.html') or exit(header('location:' . IN_PATH));
        if (!$cache->start('page_' . $page)) {
            echo Lib::L_oad($page . '.html');
            $cache->end();
        }
    } elseif ($table == 'search') {
        $letter_arr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $table_arr = array('music', 'special', 'singer', 'video', 'article');//新增Article模块
        $type = isset($index[2]) ? $index[2] : NULL;
        if (is_numeric($type)) {
            $s_like = $type;
            $s_type = 'tag';
            $page = intval(isset($index[3]) ? str_replace('p', '', $index[3]) : NULL);
            $pid = $page <= 0 ? 1 : $page;
        } elseif (in_array(strtoupper($type), $letter_arr)) {
            $s_like = $type;
            $s_type = 'letter';
            $page = intval(isset($index[3]) ? str_replace('p', '', $index[3]) : NULL);
            $pid = $page <= 0 ? 1 : $page;
        } elseif (in_array($type, $table_arr)) {
            !empty($index[3]) or exit(header('location:' . IN_PATH));
            $s_like = htmlspecialchars(trim(is_utf8($index[3])), ENT_QUOTES, set_chars(), false);
            $s_type = $type;
            $page = intval(isset($index[4]) ? str_replace('p', '', $index[4]) : NULL);
            $pid = $page <= 0 ? 1 : $page;
        } else {
            exit(header('location:' . IN_PATH));
        }
        if (!$cache->start('search_' . $s_type . '_' . $s_like . '_' . $pid)) {
            echo Lib::S_earch($s_like, $s_type, $pid, is_utf8(str_replace('[' . IN_PATH, '', '[' . $_SERVER['PHP_SELF'])));
            $cache->end();
        }
    } elseif ($table !== 'class' && !preg_match('/\\_/', $table)) {
        $info = intval(isset($index[2]) ? $index[2] : NULL);
        $id = $info < 0 ? 0 : $info;
        if (!$cache->start('info_' . $table . '_' . $id)) {
            echo Lib::I_nfo($id, $table);
            $cache->end();
        }
    } else {
        $list = intval(isset($index[2]) ? $index[2] : NULL);
        $id = $list < 0 ? 0 : $list;
        $page = intval(isset($index[3]) ? str_replace('p', '', $index[3]) : NULL);
        $pid = $page <= 0 ? 1 : $page;
        if (!$cache->start('list_' . $table . '_' . $id . '_' . $pid)) {
            echo Lib::L_ist($id, $table, $pid, str_replace('[' . IN_PATH, '', '[' . $_SERVER['PHP_SELF']));
            $cache->end();
        }
    }
} else {
    if (!$cache->start('page_index')) {
        echo Lib::L_oad('index.html');
        $cache->end();
    }
}