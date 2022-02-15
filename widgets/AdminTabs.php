<?php

namespace themroc\humhub\modules\iframe\widgets;

use Yii;
use yii\helpers\Url;

/**
 * Iframes Administration Menu
 */
class AdminTabs extends \humhub\widgets\BaseMenu
{
	/**
	 * @inheritdoc
	 */
	public $template = "@humhub/widgets/views/tabMenu";

	public function init ()
	{
		$controller= Yii::$app->controller;
		$frame= Yii::$app->request->get('frame');
		$mod= Yii::$app->getModule('iframe');
		foreach ($mod->getFrames() as $f)
			$this->addItem([
				'label'=> $mod->getSetting('label', $f),
				'url'=> Url::to(['/iframe/admin', 'frame'=>$f]),
				'sortOrder'=> $mod->getSetting('/sort'. $f),
				'isActive'=> $f == $frame,
			]);

		$this->addItem([
			'label'=> '&nbsp; + &nbsp;',
			'url'=> Url::to(['/iframe/admin']),
			'sortOrder'=> 9999999,
			'isActive'=> $frame == null,
		]);

		parent::init();
	}
}
