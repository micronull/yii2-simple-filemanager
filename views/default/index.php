<?php

use yii\helpers\Html;
use \DeLuxis\Yii2SimpleFilemanager\models\Directory;
use \DeLuxis\Yii2SimpleFilemanager\models\File;
use \DeLuxis\Yii2SimpleFilemanager\models\Item;

/** @var \yii\data\ArrayDataProvider $dataProvider */
/** @var Directory $directory */

\DeLuxis\Yii2SimpleFilemanager\assets\Asset::register($this);

$this->title = Yii::t('filemanager', 'File manager');

if ( ! isset($this->params['breadcrumbs'])) {
    $this->params['breadcrumbs'] = [];
}

if ($directory->isRoot) {
    $this->params['breadcrumbs'][] = $this->title;
} else {
    $this->params['breadcrumbs'] = array_merge($this->params['breadcrumbs'], $directory->breadcrumbs);
    $this->title                 .= ' ' . $directory->name;
}

?>
    <div class="simple-filemanager">
        <p>
            <?= Html::a('<i class="fa fa-folder fa-fw"></i> ' . Yii::t('filemanager', 'Create directory'),
                ['directory/create', 'path' => $directory->path],
                ['class' => 'btn btn-success']) ?>
            <?= Html::a('<i class="fa fa-upload fa-fw"></i> ' . Yii::t('filemanager', 'Upload files'),
                ['file/upload', 'path' => $directory->path],
                ['class' => 'btn btn-primary']) ?>
        </p>
    </div>
<?php

echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        [
            'class'     => 'yii\grid\DataColumn',
            'attribute' => 'name',
            'value'     => function ($item) {
                return Html::tag('i', '', ['class' => 'fa ' . $item->icon . ' fa-fw']) . ' ' . Html::a($item->name,
                        $item instanceof File ? $item->url : ['index', 'path' => $item->path]);
            },
            'format'    => 'html'
        ],
        [
            'class' => 'yii\grid\DataColumn',
            'headerOptions'  => ['class' => 'col-xs-1'],
            'label' => \Yii::t('filemanager', 'Size'),
            'attribute' => 'size',
            'value' => function($item){
                return $item instanceof File ? \Yii::$app->formatter->asShortSize($item->size) : '';
            }
        ],
        [
            'class'          => 'yii\grid\ActionColumn',
            'headerOptions'  => ['class' => 'col-xs-1'],
            'urlCreator'     => function ($action, $model) {
                return [
                    strtolower((new \ReflectionClass($model))->getShortName()) . '/' . $action,
                    'path' => $model->path
                ];
            },
            'visibleButtons' => [
                'view'   => function ($model) {
                    return false;
                },
                'update' => function ($model) {
                    return $model instanceof Directory;
                },
                'delete' => function ($model) {
                    return $model instanceof Item;
                }
            ]
        ],
    ],
]);