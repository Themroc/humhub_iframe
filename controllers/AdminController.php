<?php

namespace themroc\humhub\modules\iframe\controllers;

use Yii;
use humhub\modules\admin\components\Controller;
use themroc\humhub\modules\modhelper\behaviors\MhAdminController;
use themroc\humhub\modules\iframe\models\AdminForm;
use themroc\humhub\modules\iframe\widgets\AdminTabs;

class AdminController extends Controller
{
	const MH_MIN_REL= '0.2.3';

	public $adminOnly= true;
	public $isTabbed= true;

	/**
	 * Render admin only page
	 *
	 * @return string
	 */
	public function actionIndex ()
	{
		if (null == $mh= Yii::$app->getModule('mod-helper') || version_compare($mh->getVersion(), self::MH_MIN_REL) < 0)
			return $this->render('error', [
				'msg'=> 'Please install and activate the'
					.' <a href="https://github.com/Themroc/humhub_mod-helper" target="_blank">Mod-Helper plugin</a>,'
					.' at least version '.self::MH_MIN_REL.'.',
			]);

		$this->attachBehavior('MhAdmin', new MhAdminController());

		return $this->MHactionIndex(AdminForm::class, AdminTabs::class);
	}
}
