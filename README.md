# Nested Sets Menu Widget
Widget to display nested sets as Menu

![Packagist](https://img.shields.io/packagist/dt/startpl/yii2-nested-sets-menu) ![Packagist Version](https://img.shields.io/packagist/v/startpl/yii2-nested-sets-menu)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist startpl/yii2-nested-sets-menu "*"
```

or add

```
"startpl/yii2-nested-sets-menu": "*"
```

to the require section of your `composer.json` file.


## Usage
-----
A basic usage looks like the following:
 ```php
 * <?= Menu::widget([
 *     'items' => \startpl\yii2NestedSetsMenu\services\MenuArray::getData($data), // $data is your models|rows
 *     'options' => ['id'=>'main-menu', 'class' => 'menu'],
 *     'encodeLabels'=>false,
 *     'activateParents'=>true,
 *     'activeCssClass'=>'active',
 * ]);?>
 * 
 ```
 
### Also you can extending of MenuArray, NestedSetsTreeMenu for fine-tune your data