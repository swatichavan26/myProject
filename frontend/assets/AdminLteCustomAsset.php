<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * AdminLTE Custom frontend application asset bundle.
 */
class AdminLteCustomAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/adminltecustom';
    public $css = [
        'css/custom-style.css',
    ];
    
    public $js = [
//        'js/jquery.js',
//        'js/jquery.min.js',
    ];

    public $publishOptions = [
        'forceCopy'=>true,
      ];
}
