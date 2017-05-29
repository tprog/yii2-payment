Yii2 Payment extension
======================
Extension for get payment in yii2 projects

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist tprog/yii2-payment "*"
```

or add

```
"tprog/yii2-payment": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \tprog\payment\AutoloadExample::widget(); ?>
```

## Basic setup

### Configuration

Add the following in your config:

```php
<?php
...
	'components' => [
		'payment' => [
			'class' => 'tprog\payment\Payment',
			'services' => [ // You can change the providers and their classes.
				'webmoney' => [
					// register your app here: https://code.google.com/apis/console/
					'class' => 'tprog\payment\services\WebMoneyService',
					'clientId' => '...',
					'clientSecret' => '...',
					'title' => 'Google',
				],
				'yandexMoney' => [
					// register your app here: https://dev.twitter.com/apps/new
					'class' => 'tprog\payment\services\YandexMoneyService',
					'key' => '...',
					'secret' => '...',
				],
				'interkassa' => [
					// register your app https://www.interkassa.com/registration/
					'class' => 'tprog\payment\services\InterkassaService',
					'key' => '...',
					'secret' => '...',
				],
			],
		],
		
		'i18n' => [
			'translations' => [
				'payment' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@payment/messages',
				],
			],
		],

		// (optionally) you can configure pretty urls
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
				'login/<service:webmoney|yandexmoney|interkassa|etc>' => 'site/login',
			],
		],

		// (optionally) you can configure logging
		'log' => [
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'logFile' => '@app/runtime/logs/payment.log',
					'categories' => ['tprog\payment\*'],
					'logVars' => [],
				],
			],
		],
		...
	],
...
```
