<?php

/**
 * @link https://github.com/startpl/yii2-nested-sets-menu
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/yii2-nested-sets-menu/blob/master/LICENSE
 */

namespace startpl\yii2NestedSetsMenu;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * The Menu widget is used to display nested sets data as Tree Menu
 * 
 * The main property of Menu is [[items]], which specifies the possible items in the menu.
 * A menu item can contain sub-items which specify the sub-menu under that menu item.
 *
 * A basic usage looks like the following:
 *
 * ```php
 * <?= Menu::widget([
 *     'items' => \startpl\yii2NestedSetsMenu\services\MenuArray::getData($data), // $data is your models|rows
 *     'options' => ['id'=>'#main-menu', 'class' => 'menu'],
 *     'encodeLabels'=>false,
 *     'activateParents'=>true,
 *     'activeCssClass'=>'active',
 * ]);?>
 * ```
 * 
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0.0
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
        
        $view->registerJs(
        "$('.ns-menu .collapse_btn').click(function(){

            $(this).toggleClass('open');
            $(this).parent().parent().children('ul').slideToggle();

            return false;
        });", \yii\web\View::POS_READY);
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
    
    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            if (!isset($item['label'])) {
                $item['label'] = '';
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $hasActiveChild = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
            if (!isset($item['active'])) {
                if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active'] instanceof Closure) {
                $active = $items[$i]['active'] = call_user_func($item['active'], $item, $hasActiveChild, $this->isItemActive($item), $this);
            } elseif ($item['active']) {
                $active = true;
            }
        }

        return array_values($items);
    }
}
