<?php
if(!defined('IN_ROOT')){exit('Access denied');}
Administrator(8);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo IN_CHARSET; ?>" />
    <meta http-equiv="x-ua-compatible" content="ie=7" />
    <title>所有应用</title>
    <link href="static/admincp/css/main.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="static/pack/layer/jquery.js"></script>
    <script type="text/javascript" src="static/pack/layer/confirm-lib.js"></script>
    <script type="text/javascript">
        function del_msg(href) {
            $.layer({
                shade: [0],
                area: ['auto', 'auto'],
                dialog: {
                    msg: '卸载操作不可逆，确认继续？',
                    btns: 2,
                    type: 4,
                    btn: ['确认', '取消'],
                    yes: function() {
                        location.href = href;
                    },
                    no: function() {
                        layer.msg('已取消卸载', 1, 0);
                    }
                }
            });
        }
    </script>
</head>
<body>
    <?php
        $action=SafeRequest("ac","get");
        if($action=="uninst"){
            del_plugin($_GET['id'],$_GET['dir']);
        }elseif($action=="status"){
            cut_plugin($_GET['id'],$_GET['is']);
        }
    ?>
    <div class="container">
        <script type="text/javascript">parent.document.title = 'MixMusic 管理中心 - 扩展';if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='扩展';</script>
        <div class="floattop">
            <div class="itemtitle">
                <h3>所有应用</h3>
            </div>
        </div>

        

        <table class="tb tb2">
            <tr><th class="partition">插件列表</th></tr>
        </table>

        <table class="tb tb2">
        <?php
            global $db,$develop_auth;
            $sql = "select * from ".tname('plugin')." where in_type<3 order by in_addtime desc";
            $query = $db->query($sql);
            $count = $db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
                if($count==0){
                    echo "<tr><td colspan=\"2\">暂无插件</td></tr>";
                }else{
                    while($row = $db->fetch_array($query)){
                        $in_isindex = NULL;
                        if($row['in_type']==2 && $row['in_isindex']==1){
                                $in_isindex="<img src=\"static/admincp/css/show_yes.gif\" style=\"cursor:pointer\" onclick=\"location.href='?iframe=module&ac=status&id=".$row['in_id']."&is=0';\" title=\"前台隐藏\" />&nbsp;&nbsp;";
                        }elseif($row['in_type']==2 && $row['in_isindex']==0){
                                $in_isindex="<img src=\"static/admincp/css/show_no.gif\" style=\"cursor:pointer\" onclick=\"location.href='?iframe=module&ac=status&id=".$row['in_id']."&is=1';\" title=\"前台显示\" />&nbsp;&nbsp;";
                        }
                        echo "<tr class=\"hover hover\">";
                        echo "<td valign=\"center\" style=\"width:45px\"><img src=\"source/plugin/".$row['in_dir']."/preview.jpg\" onerror=\"this.src='static/admincp/css/preview.png'\" style=\"cursor:pointer\" onclick=\"location.href='plugin.php/".$row['in_dir']."/".$row['in_file']."/';\" width=\"40\" height=\"40\" align=\"left\" /></td>";
                        echo "<td class=\"light\" valign=\"center\" style=\"width:200px\">".$row['in_name']."<span class=\"sml\">".$row['in_dir']."</span></td>";
                        echo "<td valign=\"center\"><span class=\"light\">作者: <a href=\"".$row['in_address']."\" target=\"_blank\">".$row['in_author']."</a></span></td>";
                        echo "<td align=\"right\" valign=\"center\" style=\"width:160px\">".$in_isindex."<a style=\"cursor:pointer\" onclick=\"del_msg('?iframe=module&ac=uninst&id=".$row['in_id']."&dir=".$row['in_dir']."');\">卸载</a></td>";
                        echo "</tr>";
                    }
                }
            ?>
        </table>

        <table class="tb tb2">
            <tr><th class="partition">扩展列表</th></tr>
        </table>

        <table class="tb tb2">
            <?php
                $sql = "select * from ".tname('plugin')." where in_type>2 order by in_addtime desc";
                $query = $db->query($sql);
                $count = $db->num_rows($db->query(str_replace('*', 'count(*)', $sql)));
                if($count==0){
                    echo "<tr><td colspan=\"2\">暂无扩展</td></tr>";
                }else{
                    while($row = $db->fetch_array($query)){
                        echo "<tr class=\"hover hover\">";
                        echo "<td valign=\"center\" style=\"width:45px\"><img src=\"source/plugin/".$row['in_dir']."/preview.jpg\" onerror=\"this.src='static/admincp/css/preview.png'\" width=\"40\" height=\"40\" align=\"left\" /></td>";
                        echo "<td class=\"light\" valign=\"center\" style=\"width:200px\">".$row['in_name']." <span class=\"sml\">".$row['in_dir']."</span></td>";
                        echo "<td valign=\"center\"><span class=\"light\">作者: <a href=\"".$row['in_address']."\" target=\"_blank\">".$row['in_author']."</a></span></td>";
                        echo "<td align=\"right\" valign=\"center\" style=\"width:160px\"><a style=\"cursor:pointer\" onclick=\"del_msg('?iframe=module&ac=uninst&id=".$row['in_id']."&dir=".$row['in_dir']."');\">卸载</a></td>";
                        echo "</tr>";
                    }
                }
            ?>
        </table>
    </div>
</body>
</html>

<?php
    function del_plugin($id,$dir){
        global $db;
        if(@include_once('source/plugin/'.$dir.'/function.php')){
            plugin_uninstall();
        }
        $sql="delete from ".tname('plugin')." where in_id=".intval($id);
        if($db->query($sql)){
            echo "<script type=\"text/javascript\">parent.$('menu_app').innerHTML='".Menu_App()."';</script>";
            destroyDir('source/plugin/'.$dir.'/');
            ShowMessage("恭喜您，应用卸载成功！","?iframe=module","infotitle2",3000,1);
        }
    }
    function cut_plugin($id,$is){
        global $db;
        $sql="update ".tname('plugin')." set in_isindex=".$is." where in_id=".intval($id);
        if($db->query($sql)){
            ShowMessage("恭喜您，状态切换成功！","?iframe=module","infotitle2",1000,1);
        }
    }
?>