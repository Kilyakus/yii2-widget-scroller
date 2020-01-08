<?php
namespace kilyakus\widget\scroller;

class ThemeDangerAsset extends \kilyakus\widgets\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/button-danger'],'widget-button-theme-danger');
        parent::init();
    }
}
