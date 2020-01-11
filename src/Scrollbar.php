<?php
namespace kilyakus\widget\scrollbar;

use Yii;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\ArrayHelper;

class Scrollbar extends \kilyakus\widgets\Widget
{
	const TYPE_PERFECT = 'perfect-scrollbar';
	const TYPE_MCUSTOM = 'mCustomScrollbar';

	public $tagName = 'div';

	public $options = [];

	public $pluginOptions = [];

	public $height;

	public $maxHeight;

	public $minHeight;

	protected static $_inbuiltTypes = [
		self::TYPE_PERFECT,
		self::TYPE_MCUSTOM,
	];

	public function init()
	{
		parent::init();

        if (empty($this->pluginOptions['height']))
        {
            Yii::$app->session->setFlash('error', 'Widgets/' . (new \ReflectionClass(get_class($this)))->getShortName() . ': ' . Yii::t('easyii', 'The "height" option of the scroller is required.'));
        }

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
		// if (in_array($this->type, self::$_inbuiltTypes)) {
		// 	$bundleClass = __NAMESPACE__ . '\Theme' . Inflector::id2camel($this->type) . 'Asset';
		// 	$bundleClass::register($view);
		// }
	}
}
