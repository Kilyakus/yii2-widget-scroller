# How to use:

```
use kilyalus\button\Button;
```

```
echo Button::widget([
	'title' => 'label',
	'icon' => 'fa fa-cog',
	'iconPosition' => Button::ICON_POSITION_LEFT,
	'type' => Button::TYPE_PRIMARY,
	'size' => Button::SIZE_MINI,
	'disabled' => false,
	'block' => false,
	'outline' => true,
	'hover' => true,
	'circle' => true,
	'options' => [
		'type' => 'submit'
	],
])
```