<?php
namespace kilyakus\widget\scroller;

class ThemeSuccessAsset extends \kilyakus\widgets\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/button-success'],'widget-button-theme-success');
        parent::init();
    }
}
