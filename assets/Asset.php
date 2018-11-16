<?php
namespace DeLuxis\Yii2SimpleFilemanager\assets;

use yidas\yii\fontawesome\FontawesomeAsset;
use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        FontawesomeAsset::class
    ];
}