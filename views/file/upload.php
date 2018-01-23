<?php

use yii\widgets\ActiveForm;

/* @var $directory \DeLuxis\Yii2SimpleFilemanager\models\Directory */
/* @var $model \DeLuxis\Yii2SimpleFilemanager\models\UploadForm */

$this->title = Yii::t('filemanager', 'Upload files');

if ( ! isset($this->params['breadcrumbs'])) {
    $this->params['breadcrumbs'] = [];
}

$this->params['breadcrumbs']   = array_merge($this->params['breadcrumbs'], $directory->getBreadcrumbs(false));
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-lg-4">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
        <?= $form->field($model, 'path')->label(false)->hiddenInput(['value' => $model->path]) ?>
        <?= $form->field($model, 'files[]')->fileInput(['multiple' => true]) ?>

        <div class="form-group">
            <?= \yii\helpers\Html::submitButton(\Yii::t('filemanager', 'Upload'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end() ?>

    </div>
</div>
