<?php
namespace kilyakus\widget\scroller;

class ThemeAsset extends \kilyakus\widgets\AssetBundle
{
    public $depends = [
        'kilyakus\library\base\BaseAsset',
        'kilyakus\widget\scroller\ButtonAsset'
    ];
}
