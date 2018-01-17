<?php

use yii\helpers\Html;

$this->title = Yii::t('filemanager', 'File manager');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="simple-filemanager">
    <p>
        <?= Html::a(Yii::t('filemanager', '<i class="fa fa-folder fa-fw"></i> Create directory'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('filemanager', 'Upload files'), ['upload'], ['class' => 'btn btn-primary']) ?>
    </p>
</div>
