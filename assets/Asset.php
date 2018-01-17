<?php
namespace DeLuxis\Yii2SimpleFilemanager\assets;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    public $sourcePath = '@vendor';

    public $css = ['components/font-awesome/css/font-awesome.min.css'];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}