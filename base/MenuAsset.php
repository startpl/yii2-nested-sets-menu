<?php

/**
 * @link https://github.com/startpl/yii2-nested-sets-menu
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/yii2-nested-sets-menu/blob/master/LICENSE
 */

namespace startpl\yii2NestedSetsMenu\base;

use yii\web\AssetBundle;

/**
 * This asset bundle provides the javascript files for the [[Menu]] widget.
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0.0
 */
class MenuAsset extends AssetBundle
{
    public $sourcePath = '@vendor/startpl/yii2-nested-sets-menu/assets';
    
    public $css = [
        'css/style.css',
    ];
    
    public $js = [
        //'js/script.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
