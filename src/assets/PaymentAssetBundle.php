<?php
/**
 * @author Artem Bondarenko <taxist@ua.fm>
 * @link http://github.com/tprog/yii2-payment/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace tprog\payment;

use yii\web\AssetBundle;


class PaymentAssetBundle extends AssetBundle
{
    public $sourcePath = '@payment/assets';
    public $css = [
        'css/payment.css',
    ];
    public $js = [
        'js/payment.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}