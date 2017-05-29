<?php
/**
 * Payment class file.
 *
 * @author Artem Bondarenko <taxist@ua.fm>
 * @link http://github.com/tprog/yii2-payment/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace tprog\payment;

use Yii;
use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;

class PaymentController extends Controller{

    public function actionSuccess(){

    }

    public function actionError(){

    }

    /**
     * @return IPaymentService
     */
    protected function findPayment(){


    }

}