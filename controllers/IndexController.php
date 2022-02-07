<?php

namespace themroc\humhub\modules\iframe\controllers;

use Yii;
use humhub\components\Controller;

class IndexController extends Controller
{
	public $subLayout = "@iframe/views/layouts/default";

	public function actionIndex()
	{
		$mod= Yii::$app->getModule('iframe');
		$uid= Yii::$app->user->id;
		$frame= Yii::$app->request->get('frame');
		$top_data= $mod->getSetting('top_data', $frame);
		$url= $mod->getSetting('url_reg', $frame);
		if (empty($url) || Yii::$app->user->isGuest)
			$url= $mod->getSetting('url', $frame);

		if (Yii::$app->user->isGuest) {
			$user= Yii::$app->request->userIP;
			$email= '';
		} else {
			$user= Yii::$app->user->identity->username;
			$email= Yii::$app->user->identity->email;
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

		return $this->render('index', [
			'mod'=> $mod,
			'frame'=> $frame,
			'url'=> $url,
			'top_data'=> $top_data,
		]);
	}
}
