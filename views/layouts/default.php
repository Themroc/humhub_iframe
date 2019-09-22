<?php

$frame= Yii::$app->request->get('frame');
$size= Yii::$app->getModule('iframe')->getSetting('size', $frame);

if ($size==1)
	echo $content;
else
	echo <<<EOF
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				$content
			</div>
		</div>
	</div>
</div>
EOF;
