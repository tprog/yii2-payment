<?php
/**
 * Extension class file.
 *
 * @author Artem Bondarenko <taxist@ua.fm>
 * @link http://github.com/tprog/yii2-payment/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace nodge\eauth;

use Yii;
use yii\base\BootstrapInterface;
/**
 * This is the bootstrap class for the yii2-payment extension.
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        Yii::setAlias('@payment', __DIR__);
    }
}