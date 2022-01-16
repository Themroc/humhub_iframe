<?php

use humhub\widgets\Button;

themroc\humhub\modules\iframe\assets\Assets::register($this);

$frame= Yii::$app->request->get('frame');
$mod= Yii::$app->getModule('iframe');
$url= $mod->getSetting('url_reg', $frame);
if (empty($url) || Yii::$app->user->isGuest)
	$url= $mod->getSetting('url', $frame);
if (Yii::$app->user->isGuest) {
	$uid= 0;
	$user= 'Guest-'.rand(10000000, 99999999);
	$email= '';
} else {
	$uid= Yii::$app->user->id;
	$user= Yii::$app->user->getIdentity()->__get('username');
	$email= Yii::$app->user->getIdentity()->__get('email');
}
$ustr= $user.$email.$uid;
$color= '';
for ($x=0; $x<6; $x++) {
	$c= ord(substr($ustr, $x, 1));
	$color.= dechex($c & 0x0f);
}
$url= str_replace('@UID@', $uid, $url);
$url= str_replace('@USER@', urlencode($user), $url);
$url= str_replace('@EMAIL@', urlencode($email), $url);
$url= str_replace('@COLOR@', $color, $url);

$js= [];
foreach ($mod->getFrames() as $f)
	$js[urlencode($f)]= $mod->getSetting('size', $f);
$this->registerJsConfig(['iframe'=> $js]);

echo '<div class="panel-body" style="padding:0px; margin:0px; border:0px">'."\n";
echo '<iframe src="'.$url.'" class="iframe-frame" width="100%" height="500" allowtransparency="true" frameborder="0" style="padding:0px; margin:0px; border:0px"></iframe>'."\n";
echo '</div>'."\n";
