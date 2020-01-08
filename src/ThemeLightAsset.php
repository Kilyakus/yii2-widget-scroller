<?php
namespace kilyakus\widget\scroller;

class ThemeLightAsset extends \kilyakus\widgets\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/button-light'],'widget-button-theme-light');
        parent::init();
    }
}
