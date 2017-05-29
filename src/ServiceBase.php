<?php
/**
 * ServiceBase class file.
 *
 * @author Artem Bondarenko <taxist@ua.fm>
 * @link http://github.com/tprog/yii2-payment/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */


namespace tprog\payment;


/**
 * ServiceBase provider class.
 *
 * @package application.extensions.payment
 */
abstract class ServiceBase implements IPaymentService
{
    /**
     * Returns service name(id).
     */
    public function getServiceName()
    {
        return '';
    }

    /**
     * Returns service title.
     */
    public function getServiceTitle()
    {
        return '';
    }

}