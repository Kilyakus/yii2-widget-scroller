<?php
namespace kilyakus\widget\scrollbar;

class PerfectScrollbarAsset extends \yii\web\AssetBundle
{
    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets/perfect-scrollbar';
    }
    public $css = [
        'css/widget-perfectscrollbar.css',
    ];
    public $js = [
        'js/widget-perfectscrollbar.min.js',
        'js/widget-perfectscrollbar-init.js',
    ];
    public $depends = [
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );
}
