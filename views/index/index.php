<?php

use humhub\widgets\Button;

themroc\humhub\modules\iframe\assets\Assets::register($this);

$js= [];
foreach ($mod->getFrames() as $f)
	$js[urlencode($f)]= $mod->getSetting('size', $f);
$this->registerJsConfig(['iframe'=> $js]);

echo '<div class="panel-body" style="padding:0px; margin:0px; border:0px">'."\n";
if (! empty($top_data))
	echo $top_data."\n";
echo '<iframe src="'.$url.'" class="iframe-frame" width="100%" height="500" allowtransparency="true" frameborder="0" style="padding:0px; margin:0px; border:0px"></iframe>'."\n";
echo '</div>'."\n";
