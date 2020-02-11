<?php

/**
 * @link https://github.com/startpl/yii2-nested-sets-menu
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/yii2-nested-sets-menu/blob/master/LICENSE
 */

namespace startpl\yii2NestedSetsMenu\services;

/**
 * The class helps convert an Array to a Tree
 * 
 * Is an intermediary between Array models|rows and helper of NestedSetsTree
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0.0
 */
class MenuArray
{    
    /**
     * Controls conversion from array to tree
     * 
     * @param type $collection Array models|rows from database
     * @return array
     */
    static function getData($collection): array
    {        
        $menu = [];

        if($collection){
            $nsTree = new NestedSetsTreeMenu();
            $menu = $nsTree->tree($collection);
        }

        return $menu;
    }
}
