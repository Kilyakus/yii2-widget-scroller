<?php
namespace kilyakus\widget\scroller;

class ButtonAsset extends \kilyakus\widgets\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/button'],'widget-button');
        parent::init();
    }
}
