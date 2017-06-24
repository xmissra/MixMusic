<?php
include '../../system/db.class.php';
include 'config.php';
$wechatObj = new wechatCallbackapiTest();
if(!isset($_GET['echostr'])){
        $wechatObj->responseMsg();
}else{
        $wechatObj->valid();
}
class wechatCallbackapiTest{
        public function valid(){
                $echoStr = $_GET['echostr'];
                $signature = $_GET['signature'];
                $timestamp = $_GET['timestamp'];
                $nonce = $_GET['nonce'];
                $token = in_plugin_weixin_token;
                $tmpArr = array($token, $timestamp, $nonce);
                sort($tmpArr, SORT_STRING);
                $tmpStr = implode($tmpArr);
                $tmpStr = sha1($tmpStr);
                if($tmpStr == $signature){
                        echo $echoStr;
                }
        }
        public function responseMsg(){
                $postStr = $GLOBALS['HTTP_RAW_POST_DATA'];
                if(!empty($postStr)){
                        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                        $MsgType = trim($postObj->MsgType);
                        switch($MsgType){
                                case 'event':
                                        echo $this->receiveEvent($postObj);
                                        break;
                                case 'text':
                                        echo $this->receiveText($postObj);
                                        break;
                                default:
                                        echo 'unknown msg type: '.$MsgType;
                                        break;
                        }
                }
        }
        private function receiveEvent($object){
                $Event = trim($object->Event);
                switch($Event){
                        case 'subscribe':
                                $content = "欢迎您关注".IN_NAME."！\n".IN_DESCRIPTION."\n更多好音乐尽在：".$_SERVER['HTTP_HOST']."\n回复歌曲名称、歌手名称、专辑名称可以点歌。";
                                break;
                        default:
                                $content = 'receive a new event: '.$Event;
                                break;
                }
                return $this->transmitText($object, $content);
        }
        private function receiveText($object){
                global $db;
                $keyword = trim($object->Content);
                $sql = "select * from ".tname('music')." where in_name like '%".$keyword."%'";
                $result = $db->query($sql);
                $count = $db->num_rows($db->query(preg_replace('/^select \* from/i', 'select count(*) from', $sql, 1)));
                if($count == 1){
                        $row = $db->getrow("select * from ".tname('music')." where in_name like '%".$keyword."%'");
                        $content = array('Title' => $row['in_name'], 'Description' => getfield('singer', 'in_name', 'in_id', $row['in_singerid'], '未知歌手'), 'MusicUrl' => geturl($row['in_audio']), 'HQMusicUrl' => geturl($row['in_audio']));
                }elseif($count > 1){
                        $num = 0;
                        $content = "";
                        while($row = $db->fetch_array($result)){
                                $num = $num + 1;
			        $content .= $num.". ".$row['in_name']." - ".getfield('singer', 'in_name', 'in_id', $row['in_singerid'], '未知歌手')."\n";
                        }
                        $content = $content."回复歌曲名称直接听歌！";
                }elseif($gid = $db->getone("select in_id from ".tname('singer')." where in_name like '%".$keyword."%'")){
                        $num = 0;
                        $content = "";
                        $query = $db->query("select in_name from ".tname('music')." where in_singerid=".$gid);
                        while($row = $db->fetch_array($query)){
                                $num = $num + 1;
			        $content .= $num.". ".$row['in_name']." - ".getfield('singer', 'in_name', 'in_id', $gid)."\n";
                        }
                        $content = $num == 0 ? "该歌手还没有录入歌曲！" : $content."回复歌曲名称直接听歌！";
                }elseif($zid = $db->getone("select in_id from ".tname('special')." where in_name like '%".$keyword."%'")){
                        $num = 0;
                        $content = "";
                        $query = $db->query("select in_name from ".tname('music')." where in_specialid=".$zid);
                        while($row = $db->fetch_array($query)){
                                $num = $num + 1;
			        $content .= $num.". ".$row['in_name']." - ".getfield('special', 'in_name', 'in_id', $zid)."\n";
                        }
                        $content = $num == 0 ? "该专辑还没有录入歌曲！" : $content."回复歌曲名称直接听歌！";
                }else{
                        $content = "没有查询到数据，换个关键词试试？";
                }
                if(is_array($content)){
                        return $this->transmitMusic($object, $content);
                }else{
                        return $this->transmitText($object, $content);
                }
        }
        private function transmitText($object, $content){
                $xmlTpl = '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[%s]]></Content></xml>';
                return sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        }
        private function transmitMusic($object, $musicArray){
                $itemTpl = '<Music><Title><![CDATA[%s]]></Title><Description><![CDATA[%s]]></Description><MusicUrl><![CDATA[%s]]></MusicUrl><HQMusicUrl><![CDATA[%s]]></HQMusicUrl></Music>';
                $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);
                $xmlTpl = '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[music]]></MsgType>'.$item_str.'</xml>';
                return sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        }
}
?>