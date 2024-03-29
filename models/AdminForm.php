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
	public $guest;
	public $url_reg;
	public $url_guest;
	public $top_data;

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
			'prefix'=> '<style>.regular-radio-container{display:inline !important}</style>',
			'rules'=> ['in', 'range'=> [0, 1]],
			'form'=> [
				'type'=> 'radio',
				'items'=> [self::class, 'sizeModes']
			],
		],
		'url_reg'=> [
			'label'=> 'URL for registered users',
			'hints'=> 'The webpage to be shown. @UID@, @USER@, @EMAIL@ and @COLOR@ will be replaced by the respective values.',
		],
		'guest'=> [
			'label'=> 'Visible for guests',
			'rules'=> ['in', 'range'=> [0, 1]],
			'form'=> [
				'type'=> 'checkbox',
			],
		],
		'url_guest'=> [
#		'url'=> [
			'label'=> 'URL for guests',
			'hints'=> 'If empty, the above will be used.',
			'form'=> [
				'visible'=> ['guest'=> 1],
			],
		],
		'top_data'=> [
			'label'=> 'HTML to add above the iframe',
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
