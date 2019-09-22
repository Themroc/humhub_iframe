<?php

namespace themroc\humhub\modules\iframe;

use Yii;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use humhub\components\UrlManager;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;

use themroc\humhub\modules\iframe\Assets;

class Module extends \humhub\modules\content\components\ContentContainerModule
{
	/**
	* @inheritdoc
	*/
	public function getConfigUrl()
	{
		return Url::to(['/iframe/admin']);
	}

	/**
	* @inheritdoc
	*/
	public function disable()
	{
		// Cleanup all module data, don't remove the parent::disable()!!!
		parent::disable();
	}

	public function getSetting($key, $frame=null)
	{
		return $this->settings->get(($frame==null ? '' : $frame.'/') . $key);
	}

	public function getUrl($page, $params=null)
	{
		$url= [ '/iframe/'.$page ];
		if (is_array($params))
			foreach ($params as $k => $v)
				$url[$k]= strtolower($v);

		return Url::to($url);
	}

	public function getFrames()
	{
		$frames= $this->settings->get('/frames');
		if ($frames == null)
			return [];

		return preg_split('!\s*/\s*!', $frames);
	}
}
