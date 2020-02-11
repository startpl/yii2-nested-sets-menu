<?php

/**
 * @link https://github.com/startpl/yii2-nested-sets-menu
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/yii2-nested-sets-menu/blob/master/LICENSE
 */

namespace startpl\yii2NestedSetsMenu\base;

/**
 * The helper class for building tree from Nested Sets data
 * 
 * It provides features like [[tree]], [[addItem]]
 *
 * inspired and based on klisl
 * 
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0.0
 */
class NestedSetsTree 
{
    /**
     * @var string depth attribute
     */
    public $depthAttribute = 'depth';

    /**
     * @var string attribute containing name
     */
    public $labelAttribute = 'name';

    /**
     * @var string 
     */
    public $childrenOutAttribute = 'children';



    /**
     * Building tree from Nested Sets data
     *
     * @param array $collection Array models|rows from database
     * @return array
     */
    public function tree(array $collection): array
    {

        $tree = [];

        if (count($collection) > 0) {
            foreach ($collection as &$col) {
                $col = $this->addItem($col);
            }

            // Node. use for hierarchy building
            $stack = array();

            foreach ($collection as $node) {
                $item = $node;
                $item[$this->childrenOutAttribute] = [];

                // count elements current node
                $l = count($stack);

                // checking current depth level
                while($l > 0 && $stack[$l - 1][$this->depthAttribute] >= $item[$this->depthAttribute]) {
                    array_pop($stack);
                    $l--;
                }

                // if current node is Root
                if ($l == 0) {
                    // create root node
                    $i = count($tree);
                    $tree[$i] = $item;
                    $stack[] = &$tree[$i];
                } else {
                    // Adding node to parent
                    $i = count($stack[$l - 1][$this->childrenOutAttribute]);
                    $stack[$l - 1][$this->childrenOutAttribute][$i] = $item;
                    $stack[] = &$stack[$l - 1][$this->childrenOutAttribute][$i];
                }
            }
        }

        return $tree;
    }
    
    /**
     * Adds and converts to array the node
     * 
     * @param mixed $node
     * @return array
     */
    public function addItem($node): array
    {
        $newNode = [];
        return array_merge($node, $newNode);
    }
}
