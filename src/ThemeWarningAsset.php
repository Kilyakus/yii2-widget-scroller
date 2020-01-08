<?php
namespace kilyakus\widget\scroller;

class ThemeWarningAsset extends \kilyakus\widgets\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/button-warning'],'widget-button-theme-warning');
        parent::init();
    }
}
