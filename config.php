<?php

use humhub\widgets\TopMenu;
use humhub\modules\admin\widgets\AdminMenu;
use themroc\humhub\modules\iframe\Events;

return [
	'id' => 'iframe',
	'class' => 'themroc\humhub\modules\iframe\Module',
	'namespace' => 'themroc\humhub\modules\iframe',
	'events' => [
		[ TopMenu::class, TopMenu::EVENT_INIT, [Events::class, 'onTopMenuInit'] ],
		[ AdminMenu::class, AdminMenu::EVENT_INIT, [Events::class, 'onAdminMenuInit'] ],
	],
];
