<?php

$this->beginContent('@admin/views/layouts/main.php');

echo '<div class="panel panel-default">'."\n";
echo '	<div class="panel-heading">'."\n";
echo '		<strong>Iframe</strong> ' . Yii::t('ModHelperModule.base', 'module configuration') . "\n";
echo '	</div>'."\n";
echo \themroc\humhub\modules\iframe\widgets\AdminTabs::widget();
echo '	<div class="panel-body">'."\n";
echo '		' . $content . "\n";
echo '	</div>'."\n";
echo '</div>'."\n";

$this->endContent();
