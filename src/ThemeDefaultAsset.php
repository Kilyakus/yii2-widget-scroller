<?php
namespace kilyakus\widget\scroller;

class ThemeDefaultAsset extends \kilyakus\widgets\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/button-default'],'widget-button-theme-default');
        parent::init();
    }
}
