<?php

/**
 * @link https://github.com/startpl/yii2-nested-sets-menu
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/yii2-nested-sets-menu/blob/master/LICENSE
 */

namespace startpl\yii2NestedSetsMenu\services;

use startpl\yii2NestedSetsMenu\base\NestedSetsTree;

/**
 * The helper class for building tree from Nested Sets data
 * 
 * It provides features like [[tree]], [[addItem]], [[renameTitle]], [[visable]], [[makeActive]]
 *
 * inspired and based on klisl
 * 
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0.0
 */
class NestedSetsTreeMenu extends NestedSetsTree
{

    /**
     * @var string 
     */
    public $childrenOutAttribute = 'items';

    /**
     * @var string attribute label
     */
    public $labelOutAttribute = 'label';


    /**
     * Adds and configures the node
     * 
     * @param $node
     * @return array
     */
    public function addItem($node): array
    {
        $this->renameTitle($node); //переименование элемента массива
        $this->visible($node); //видимость элементов меню
        $this->makeActive($node); //выделение активного пункта меню
        return $node;
    }

    /**
     * Rename the element "name" to "label" (create a label, delete name)
     * required for yii\widgets\Menu
     * 
     * @param $node
     */
    protected function renameTitle(&$node)
    {
        $node[$this->labelOutAttribute] = $node[$this->labelAttribute];
        unset($node[$this->labelAttribute]);
    }


    /**
     * Sets element visibility (false - invisible, true = visible);
     * 
     * @param $node
     */
    protected function visible(&$node)
    {
        if (\Yii::$app->user->isGuest) {
            if ($node['url'] == '/logout') {
                $node['visible'] = false;
            }
        } 
        else {
            if ($node['url'] == '/login' || $node['url'] == '/signup') {
                $node['visible'] = false;
            }
        }
    }



    /**
     * Sets the activity of the node, if his url matches the current
     *
     * @param $node
     */
    private function makeActive(&$node)
    {
        $path = Yii::$app->request->getPathInfo();

        if('/' . $path == $node['url']){
            $node['active'] = true;
        }
    }

}