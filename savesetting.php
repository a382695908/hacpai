<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action = 'root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('hacpai')) {$zbp->ShowError(48);die();}
switch (GetVars('action', 'GET')) {
case 'cleanup':
	$zbp->DelConfig('hacpai');
	hacpai_init();
	break;
case 'save':
	$zbp->Config('hacpai')->email = GetVars('hacpai_email', 'post');
	$zbp->Config('hacpai')->key = GetVars('hacpai_key', 'post');
	$zbp->SaveConfig('hacpai');
	break;
default:
}
$zbp->SetHint('good');
Redirect('settings.php');
