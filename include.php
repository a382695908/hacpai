<?php
#注册插件
RegisterPlugin("hacpai", "ActivePlugin_hacpai");

function ActivePlugin_hacpai() {
	// Check if is a new article
	Add_Filter_Plugin('Filter_Plugin_PostArticle_Core', "hacpai_postarticle_code");
	// Sync to hacpai
	Add_Filter_Plugin('Filter_Plugin_PostArticle_Succeed', "hacpai_postarticle_succeed");
	Add_Filter_Plugin('Filter_Plugin_PostComment_Succeed', "hacpai_postcomment_succeed");

}

function InstallPlugin_hacpai() {}
function UninstallPlugin_hacpai() {}