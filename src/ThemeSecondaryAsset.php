<?php
namespace kilyakus\widget\scroller;

class ThemeSecondaryAsset extends \kilyakus\widgets\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/button-secondary'],'widget-button-theme-secondary');
        parent::init();
    }
}
