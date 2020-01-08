<?php
namespace kilyakus\widget\scroller;

use Yii;
use yii\helpers\Html;
use yii\helpers\Inflector;

/*
	For example:
	
	echo Button::widget([
		'title' => 'label',
		'icon' => 'fa fa-cog',
		'iconPosition' => Widget\Button::ICON_POSITION_LEFT,
		'type' => Widget\Button::TYPE_PRIMARY,
		'size' => Widget\Button::SIZE_MINI,
		'disabled' => false,
		'block' => false,
		'outline' => true,
		'hover' => true,
		'circle' => true,
		'options' => ['type' => 'submit'],
	])
*/
class Widget extends \yii\base\Widget
{
	public $pluginName = 'scroller';

	const TYPE_DEFAULT = 'default';
	const TYPE_BRAND = 'brand';
	const TYPE_DANGER = 'danger';
	const TYPE_DARK = 'dark';
	const TYPE_INFO = 'info';
	const TYPE_LIGHT = 'light';
	const TYPE_LINK = 'link';
	const TYPE_PRIMARY = 'primary';
	const TYPE_SECONDARY = 'secondary';
	const TYPE_SUCCESS = 'success';
	const TYPE_WARNING = 'warning';
	const TYPE_TRANSPARENT = 'transparent';

	const SIZE_MINI = 'xs';
	const SIZE_SMALL = 'sm';
	const SIZE_LARGE = 'lg';

	const ICON_POSITION_LEFT = 'left';
	const ICON_POSITION_RIGHT = 'right';

	public $title;

	/**
	 * @var string The button size.
	 * Valid values are 'xs', 'sm', 'lg'.
	 */
	public $size;

	/**
	 * @var string The button type.
	 * Valid values for engine styles are 'red', 'blue', 'green', 'yellow', 'purple'.
	 * Valid values for bootstrap styles are 'default', 'danger', 'dark', 'info', 'light', 'link', 'primary', 'secondary', 'success', 'warning'.
	 */
	public $type = self::TYPE_DEFAULT;
	public $combine;

	public $color = '';

	public $icon;
	public $iconPosition = self::ICON_POSITION_LEFT;

	public $disabled = false;

	public $block = false;

	public $hover = false;

	public $outline = false;

	public $elevate = false;

	public $air = false;

	public $pill = false;

	public $label = false;

	public $circle = false;

	public $upper = false;

	public $url;

	private $_sizes = [
		self::SIZE_MINI,
		self::SIZE_SMALL,
		self::SIZE_LARGE,
	];

	protected static $_inbuiltTypes = [
		self::TYPE_DEFAULT,
		self::TYPE_BRAND,
		self::TYPE_DANGER,
		self::TYPE_DARK,
		self::TYPE_INFO,
		self::TYPE_LIGHT,
		self::TYPE_LINK,
		self::TYPE_PRIMARY,
		self::TYPE_SECONDARY,
		self::TYPE_SUCCESS,
		self::TYPE_WARNING,
		self::TYPE_TRANSPARENT,
	];

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();

		if(!empty($this->options['options'])){
			$this->options = array_merge($this->options, $this->options['options']);
			unset($this->options['options']);
		}

		$this->combine = $this->type;

		if ($this->hover === true)
		{
			$this->combine = 'hover-' . $this->combine;
		}

		if ($this->outline === true)
		{
			$this->combine = 'outline-' . $this->combine;
		}

		if ($this->label === true)
		{
			Html::addCssClass($this->options, 'btn-label-' . $this->combine);
		}else{
			Html::addCssClass($this->options, sprintf('btn-%s', $this->combine));
		}

		Html::addCssClass($this->options, $this->color);

		if (in_array($this->size, $this->_sizes))
		{
			Html::addCssClass($this->options, 'btn-' . $this->size);
		}

		if ($this->disabled === true)
		{
			Html::addCssClass($this->options, 'disabled');
		}

		if ($this->block === true)
		{
			Html::addCssClass($this->options, 'btn-block');
		}

		if ($this->circle === true)
		{
			Html::addCssClass($this->options, 'btn-icon btn-circle');
		}

		if ($this->upper === true)
		{
			Html::addCssClass($this->options, 'btn-upper');
		}

		if (isset($this->url)){

            $this->tagName = 'a';
			$this->options = array_merge($this->options, ['href' => $this->url]);

		}else{

			if(!isset($this->options['type']) && ($this->tagName == 'button' || $this->tagName == 'input'))
			{
				$this->options['type'] = 'button';
			}

		}
	}

	public function run()
	{
		$title = $this->encodeLabel ? Html::encode($this->title) : $this->title;

		if ($this->icon !== null)
		{
			$paddings = $title ? '' : 'pr-0'; 
			$icon = Html::tag('i', '', ['class' => $this->icon . ' ' . $paddings]);
			$title = strcasecmp($this->iconPosition, self::ICON_POSITION_LEFT) === 0 ? sprintf('%s %s', $icon, $title) : sprintf('%s %s', $title, $icon);
		}

		echo Html::tag($this->tagName, $title, $this->options);

		$this->registerPlugin('button');
		$this->registerAssets();
	}

	public function registerAssetBundle()
	{
		$view = $this->getView();
		ButtonAsset::register($view);
		if (in_array($this->type, self::$_inbuiltTypes)) {
			$bundleClass = __NAMESPACE__ . '\Theme' . Inflector::id2camel($this->type) . 'Asset';
			$bundleClass::register($view);
		}
	}

	public function registerAssets()
	{
		$this->registerAssetBundle();
		$this->registerPlugin($this->pluginName);
	}
}
