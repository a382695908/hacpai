<?php
#注册插件
RegisterPlugin("hacpai", "ActivePlugin_hacpai");
define('HACPAI_API_ARTICLE', 'http://rhythm.b3log.org/api/article');
define('HACPAI_API_COMMENT', 'http://rhythm.b3log.org/api/comment');

function ActivePlugin_hacpai() {
	// Sync to hacpai
	Add_Filter_Plugin('Filter_Plugin_PostArticle_Succeed', "hacpai_postarticle_succeed");
	Add_Filter_Plugin('Filter_Plugin_PostComment_Succeed', "hacpai_postcomment_succeed");

}

function InstallPlugin_hacpai() {
	hacpai_init();
}

function UninstallPlugin_hacpai() {}

function hacpai_init() {
	global $zbp;
	if (!isset($zbp->Config('hacpai')->version)) {
		$zbp->Config('hacpai')->email = '';
		$zbp->Config('hacpai')->key = '';
		$zbp->Config('hacpai')->version = '1.0';
		$zbp->SaveConfig('hacpai');
	}
}

function hacpai_post($url, $data) {
	$network = Network::Create();
	$network->open('POST', $url);
	$network->setRequestHeader('Content-Type', 'application/json');
	$network->send(json_encode($data));
	return $network->responseText;
}

function hacpai_postarticle_succeed(&$article) {
	global $zbp;
	$postData = array(
		"article" => array(
			"id" => $article->ID,
			"title" => $article->Title,
			"permalink" => $article->Url,
			"tags" => $article->TagsName,
			"content" => $article->Content,
		),
		"client" => array(
			"title" => $zbp->title,
			"host" => $zbp->host,
			"email" => $zbp->Config('hacpai')->email,
			"key" => $zbp->Config('hacpai')->key,
		));
	hacpai_post(HACPAI_API_ARTICLE, $postData);
}

function hacpai_postcomment_succeed(&$comment) {
	global $zbp;
	$postData = array(
		"comment" => array(
			"id" => $comment->ID,
			"articleId" => $comment->LogId,
			"content" => $comment->Content,
			"authorName" => $comment->Name,
			"authorEmail" => $comment->Email,
		),
		"client" => array(
			"title" => $zbp->title,
			"host" => $zbp->host,
			"email" => $zbp->Config('hacpai')->email,
			"key" => $zbp->Config('hacpai')->key,
		));
	hacpai_post(HACPAI_API_COMMENT, $postData);
}