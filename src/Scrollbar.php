<?php
namespace kilyakus\widget\scrollbar;

use Yii;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\ArrayHelper;

class Scrollbar extends \kilyakus\widgets\Widget
{
	const TYPE_PS = 'perfect';
	const TYPE_MC = 'mcustom';

	public $type = self::TYPE_PS;

	public $tagName = 'div';

	public $options = [];

	public $pluginOptions = [];

	public $height;

	public $maxHeight;

	public $minHeight;

	protected static $_inbuiltTypes = [
		self::TYPE_PS,
		self::TYPE_MC,
	];

	public function init()
	{
		parent::init();

		// $this->height = ($this->maxHeight && !$this->height) ? $this->maxHeight : $this->height;

		echo '<!-- begin:: Widgets/Scroller -->';

		$this->_renderScrollerBegin();
	}

	public function run()
	{
		$this->_renderScrollerEnd();

		echo '<!-- end:: Widgets/Scroller -->';

		$this->registerAssetBundle();
	}


    private function _renderScrollerBegin()
    {
        Html::addCssStyle($this->options, ['height' => $this->height]);
        Html::addCssStyle($this->options, ['max-height' => $this->maxHeight]);
        Html::addCssStyle($this->options, ['min-height' => $this->minHeight]);

        echo Html::beginTag(
                $this->tagName, ArrayHelper::merge(
                    [
                    	'data-scroll' => 'true',
                    	'data-height' => $this->height,
                    	'data-mobile-height' => $this->height
                    ],
                    $this->options
                )
        );
    }

    private function _renderScrollerEnd()
    {
        echo Html::endTag($this->tagName);
    }

	public function registerAssetBundle()
	{
		$view = $this->getView();
		// ButtonAsset::register($view);
		if (in_array($this->type, self::$_inbuiltTypes)) {
			$bundleClass = __NAMESPACE__ . '\\' . Inflector::id2camel($this->type) . 'Scrollbar' . 'Asset';
			$bundleClass::register($view);
		}

		$view->registerJs("$('[data-scroll=\"true\"]').each(function() {
    var el = $(this);
    PS_WIDGET.scrollInit(this, {
        mobileNativeScroll: true,
        handleWindowResize: true,
        rememberPosition: (el.data('remember-position') == 'true' ? true : false),
        height: function() {
            if (PS_WIDGET.isInResponsiveRange('tablet-and-mobile') && el.data('mobile-height')) {
                return el.data('mobile-height');
            } else {
                return el.data('height');
            }
        }
    });
});", $view::POS_END, 'widget-ps');

	}
}
