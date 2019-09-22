<?php

namespace themroc\humhub\modules\iframe\controllers;

use Yii;
use humhub\components\Controller;

class IndexController extends Controller
{
	public $subLayout = "@iframe/views/layouts/default";

	public function actionIndex()
	{
		return $this->render('index', [
		]);
	}
}
