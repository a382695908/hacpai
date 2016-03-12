<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
if (!$zbp->CheckPlugin('hacpai')) {$zbp->ShowError(48);die();}

$rawData = null;
if (!isset($GLOBALS['HTTP_RAW_POST_DATA'])) {
	$rawData = file_get_contents("php://input");
} else {
	$rawData = $GLOBALS['HTTP_RAW_POST_DATA'];
}
$rawData = trim($rawData);
$result = json_decode($rawData);
if ($result->client->key !== $zbp->Config('hacpai')->b3logKey) {
	exit;
}

switch (GetVars('action', 'GET')) {
case 'comment':
	syncComment();
	break;
default:
	exit;
}

function syncComment() {
	global $zbp;
	global $result;

	$article = new Article();
	$comment = new Comment();

	$article->LoadInfoByID($result->comment->articleId);
	if ($article->ID == 0) {
		exit;
	}
	$authorName = $article->Author->Name;
	if ($authorName == $comment->Name) {
		$comment->AuthorID = $article->Author->ID;
	}

	$comment->Name = $result->comment->authorName;
	$comment->Email = $result->comment->authorEmail;
	$comment->HomePage = $result->comment->authorURL;
	$comment->LogID = $result->comment->articleId;
	$comment->Content = $result->comment->content;
	$comment->PostTime = time();
	$comment->IP = GetGuestIP();
	$comment->Agent = GetGuestAgent();
	$comment->Metas->HacpaiOriginalData = $result->comment->content;
	filterComment($comment);
	$comment->Save();
}

/**
 * Filter Comment
 * @param &$comment
 */
function filterComment(&$comment) {
	global $zbp;
	if (!CheckRegExp($comment->Name, '[username]')) {
		$comment->Name = $zbp->lang['user_level_name'][5];
	}

	if ($comment->Email && (!CheckRegExp($comment->Email, '[email]'))) {
		$comment->Email = 'null@null.com';
	}

	if ($comment->HomePage && (!CheckRegExp($comment->HomePage, '[homepage]'))) {
		$comment->HomePage = $zbp->host;
	}

	$comment->Name = substr($comment->Name, 0, 20);
	$comment->Email = substr($comment->Email, 0, 30);
	$comment->HomePage = substr($comment->HomePage, 0, 100);
	$comment->Content = TransferHTML($comment->Content, '[nohtml]');
	$comment->Content = substr($comment->Content, 0, 1000);
	$comment->Content = trim($comment->Content);
	if (strlen($comment->Content) == 0) {
		return;
	}
}
