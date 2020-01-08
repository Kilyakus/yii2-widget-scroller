<?php
namespace kilyakus\widget\scroller;

class ThemeTransparentAsset extends \kilyakus\widgets\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/button-transparent'],'widget-button-theme-transparent');
        parent::init();
    }
}
