<?php

use yii\helpers\Html;

\DeLuxis\Yii2SimpleFilemanager\assets\Asset::register($this);

$this->title = Yii::t('filemanager', 'File manager');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="simple-filemanager">
    <p>
        <?= Html::a('<i class="fa fa-folder fa-fw"></i> ' . Yii::t('filemanager', 'Create directory'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fa fa-upload fa-fw"></i> ' . Yii::t('filemanager', 'Upload files'), ['upload'], ['class' => 'btn btn-primary']) ?>
    </p>
</div>
