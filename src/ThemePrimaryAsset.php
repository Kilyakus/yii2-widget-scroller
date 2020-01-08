<?php
namespace kilyakus\widget\scroller;

class ThemePrimaryAsset extends \kilyakus\widgets\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/button-primary'],'widget-button-theme-primary');
        parent::init();
    }
}
