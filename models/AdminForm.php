<?php

namespace themroc\humhub\modules\iframe\models;

use Yii;
use yii\helpers\Url;
use humhub\libs\Html;
use humhub\modules\ui\form\widgets\IconPicker;

/**
 * AdminForm defines the configurable fields.
 */
class AdminForm extends \themroc\humhub\modules\modhelper\models\AdminForm
{
	public $icon;
	public $label;
	public $sort;
	public $size;
	public $url;
	public $url_reg;

	protected $vars= [
		'label'=> [
			'hints'=> 'This will show up under the icon',
		],
		'icon'=> [
			'form'=> [
				'type'=> 'widget',
				'class'=> IconPicker::class,
			],
		],
		'sort'=> [
			'label'=> 'Sort order',
			'hints'=> 'Determines topbar menu position',
		],
		'size'=> [
			'rules'=> ['in', 'range'=> [0, 1]],
			'form'=> [
				'type'=> 'radio',
				'items'=> [self::class, 'sizeModes']
			],
		],
		'url'=> [
			'label'=> 'Page URL',
			'hints'=> 'The webpage to be shown. @UID@, @USER@ and @EMAIL@ will be replaced by the respective values.',
		],
		'url_reg'=> [
			'label'=> 'Page URL for registered users',
			'hints'=> 'If empty, the above will be used.',
		],
	];

	protected $mod= [
		'form'=> [
			'btn_post'=> [self::class, 'deleteButton']
		],
	];

	/**
	 * @inheritdoc
	 */
	public function save ()
	{
		$frame= strtolower($this->label);
		$this->mod['prefix']= $frame.'/';
		$frames= $this->mod['_']->getFrames();
		$fs= [];
		foreach ($frames as $f)
			$fs[$f]= $this->mod['settings']->get($f.'/sort');
		$fs[$frame]= $this->sort;
		asort($fs);
		if (join('/', $frames) != ($frames_str= join('/', array_keys($fs))))
			$this->mod['settings']->set('/frames', $frames_str);

		foreach ($this->vars as $name => $v)
			$this->mod['settings']->set($this->mod['prefix'].$name, trim($this->{$name}));

		return $this->loadSettings();
	}

	public function deleteButton ($model)
	{
		return strlen($model->label)
			? "\t\t\t".Html::a(
				Yii::t('IframeModule.base', 'Delete'),
				$model->getMod('_')->getUrl('admin', ['frame'=> $model->label, 'delete'=> '1']),
				['class' => 'btn btn-default pull-right', 'style'=>'margin-right:10px'])."\n"
			: "";
	}

	public function sizeModes ()
	{
		return [
			0=> Yii::t('IframeModule.base', 'Box'),
			1=> Yii::t('IframeModule.base', 'Fullscreen'),
		];
	}
}
