<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace startpl\yii2NestedSetsMenu;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Description of CategoriesMenu
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0
 */
class Menu extends \yii\widgets\Menu{
    
    const CHILDREN_ATTRIBUTE = 'items';
    
    public $linkTemplate = "\n<a href='{url}'>{label}{dropdown-icon}</a>\n";
    public $submenuTemplate = "\n<ul class='treeview-menu'>\n{items}\n</ul>\n";
    
    public $dropdownOptions = ['class' => 'collapse_btn glyphicon glyphicon-chevron-left'];
    
    public function init() {
        parent::init();
        
        Html::addCssClass($this->options, 'ns-menu');
    }
    
    public function run() {
        parent::run();
        
        $view = $this->getView();
        base\MenuAsset::register($view);
    }
    
    protected function renderItem($item)
    {
        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
            
            $tmpOptions = $this->dropdownOptions;
            
            if($item['active']){
                Html::addCssClass($tmpOptions, 'open');
            }
            
            return strtr($template, [
                '{dropdown-icon}' => ($item[static::CHILDREN_ATTRIBUTE] !== null)? 
                    Html::tag('span', '', $tmpOptions) : '',
                '{url}' => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
            ]);
        }

        $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }
}
