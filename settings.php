<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action = 'root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('hacpai')) {$zbp->ShowError(48);die();}

$blogtitle = 'hacpai';
require $blogpath . 'zb_system/admin/admin_header.php';
?>
<style type="text/css">
tr {
	height: 32px;
}
#divMain2 ul li {
	margin-top: 6px;
	margin-bottom: 6px
}
.bold {
	font-weight: bold;
}
.note {
	margin-left: 10px
}
</style>
<?php
require $blogpath . 'zb_system/admin/admin_top.php';
?>
<div id="divMain">
  <div class="divHeader"><?php echo $blogtitle; ?></div>
  <div class="SubMenu">
  </div>
  <div id="divMain2">
<form action="savesetting.php?action=save" method="post">
  <table width="100%" class="tableFull tableBorder table_striped table_hover" >
    <thead>
      <tr>
        <th width="30%">配置项 </th>
        <th>选择 </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><p><span class="bold"> · 接口地址</span></p></td>
        <td>
        	<p>客户端收文接口：<a href="<?php echo $bloghost; ?>zb_users/plugin/hacpai/receiver.php?action=article" onclick="return false;"><?php echo $bloghost; ?>zb_users/plugin/hacpai/receiver.php?action=article</a></p>
        	<p>客户端收评接口：<a href="<?php echo $bloghost; ?>zb_users/plugin/hacpai/receiver.php?action=comment" onclick="return false;"><?php echo $bloghost; ?>zb_users/plugin/hacpai/receiver.php?action=comment</a></p>
        </td>
      </tr>
      <tr>
        <td><p><span class="bold"> · 黑客派社区邮箱</span></p></td>
        <td><input type="text" name="hacpai_email" value="<?php echo $zbp->Config("hacpai")->email; ?>" style="width:50%"/></td>
      </tr>
      <tr>
        <td><p><span class="bold"> · B3log Key</span></p></td>
        <td><input type="text" name="hacpai_key" value="<?php echo $zbp->Config("hacpai")->key; ?>" style="width:50%"/></td>
      </tr>
      <tr>
        <td><p><span class="bold"> · 其它</span></p></td>
        <td><p>
            <input name="" type="button" class="button" onClick="if(confirm('你确定要继续吗？')){location.href='savesetting.php?action=cleanup'}" value="清空插件配置" />
          </p></td>
      </tr>
    </tbody>
    <tfoot>
    </tfoot>
  </table>
  <p>
    <input type="submit" class="button" value="提交" />
  </p>
</form>


  </div>
</div>

<?php
require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();
?>