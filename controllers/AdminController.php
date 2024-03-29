<?php

namespace themroc\humhub\modules\iframe\controllers;

use Yii;
use humhub\modules\admin\components\Controller;
use themroc\humhub\modules\iframe\models\AdminForm;

class AdminController extends Controller
{
	const MH_MIN_REL= '0.2.1';

	public $adminOnly= true;
	public $subLayout= '@iframe/views/layouts/admin';

	public function init ()
	{
		if (null == $mod= Yii::$app->getModule('mod-helper'))
			$this->subLayout= null;
		if (version_compare($mod->getVersion(), self::MH_MIN_REL) < 0)
			$this->subLayout= null;

		return parent::init();
	}


	/**
	 * Render admin only page
	 *
	 * @return string
	 */
	public function actionIndex ()
	{
		if ($this->subLayout===null)
			return $this->render('error', [
				'msg'=> 'Please install and activate the'
					.' <a href="https://github.com/Themroc/humhub_mod-helper" target="_blank">Mod-Helper plugin</a>,'
					.' at least version '.self::MH_MIN_REL.'.',
			]);

		$mod= Yii::$app->getModule('iframe');
		$mod->update();
		$frame= Yii::$app->request->get('frame');

		if (Yii::$app->request->get('delete') == 1) {
			$model= new AdminForm();
			foreach (array_keys($model->getVars()) as $v)
				$mod->settings->delete($frame.'/'.$v);
			$frames= $mod->getFrames();
			if (false !== $k= array_search($frame, $frames)) {
				unset($frames[$k]);
				$mod->settings->set('/frames', join('/', $frames));
			}

			return $this->redirect($mod->getUrl('admin'));
		}

		$model= new AdminForm(isset($frame) ? $frame.'/' : '');
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$this->view->saved();

			return $this->redirect($mod->getUrl('admin'));
		}

		return $this->render('@mod-helper/views/form', [
			'model'=> $model,
			'standAlone'=> 0,
		]);
	}
}
