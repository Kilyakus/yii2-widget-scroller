<?php
namespace kilyakus\widget\scroller;

class ThemeInfoAsset extends \kilyakus\widgets\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/button-info'],'widget-button-theme-info');
        parent::init();
    }
}
