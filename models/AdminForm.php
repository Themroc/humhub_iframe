<?php

namespace themroc\humhub\modules\iframe\models;

use Yii;
use yii\helpers\Url;
use humhub\libs\Html;
use humhub\modules\ui\form\widgets\IconPicker;
use themroc\humhub\modules\modhelper\models\MhAdminForm;

/**
 * AdminForm defines the configurable fields.
 */
class AdminForm extends MhAdminForm
{
	const MH_API= 1;

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

	public function sizeModes ()
	{
		return [
			0=> Yii::t('IframeModule.base', 'Box'),
			1=> Yii::t('IframeModule.base', 'Fullscreen'),
		];
	}
}
