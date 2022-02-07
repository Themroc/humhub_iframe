<?php

namespace themroc\humhub\modules\iframe;

use Yii;

class Events
{
	/**
	 * Defines what to do when the top menu is initialized.
	 *
	 * @param $event
	 */
	public static function onTopMenuInit ($event)
	{
		$mod= Yii::$app->getModule('iframe');
		$guest= Yii::$app->user->isGuest;

		foreach ($mod->getFrames() as $f) {
			if ($guest && (! $mod->getSetting('guest', $f)))
				continue;
			$prefix= $f.'/';
			$label= $mod->getSetting('label', $f);
			$event->sender->addItem([
				'icon'=> '<i class="fa fa-'.$mod->getSetting($prefix.'icon').'"></i>',
				'label'=> $label,
				'top_data'=> $mod->getSetting('top_data', $f),
				'url'=> $mod->getUrl('index', ['frame'=> $label]),
				'sortOrder'=> $mod->getSetting('sort', $f),
				'isActive'=> self::checkActive('index', $f),
			]);
		}
	}

	/**
	 * Defines what to do if admin menu is initialized.
	 *
	 * @param $event
	 */
	public static function onAdminMenuInit ($event)
	{
		$mod= Yii::$app->getModule('iframe');
		if (! Yii::$app->controller->module || ! Yii::$app->controller->module->id == 'iframe')
			return;

		$event->sender->addItem([
			'icon'=> '<i class="fa fa-desktop"></i>',
			'label'=> 'Iframe',
			'url'=> $mod->getUrl('admin'),
			'group'=> 'manage',
			'sortOrder'=> 99999,
			'isActive'=> self::checkActive('admin'),
		]);
	}

	/**
	 * Defines what to do when the top menu is initialized.
	 *
	 * @param $event
	 */
	public static function checkActive ($page, $frame= null)
	{
		if ((! Yii::$app->controller->module) || Yii::$app->controller->module->id != 'iframe' || Yii::$app->controller->id != $page)
			return 0;

		return $frame==null ? 1 : (Yii::$app->request->get('frame') == $frame);
	}
}
