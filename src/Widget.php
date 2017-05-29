<?php
/**
 * Widget class file.
 *
 * @author Artem Bondarenko <taxist@ua.fm>
 * @link http://github.com/tprog/yii2-payment/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace tprog\payment;

use Yii;

/**
 * The PaymentWidget widget prints buttons to authenticate user with OpenID and OAuth providers.
 *
 * @package application.extensions.payment
 */
class Widget extends \yii\base\Widget
{
    /**
     * @var string Payment component name.
     */
    public $component = 'payment';
    /**
     * @var array the services.
     * @see Payment::getServices()
     */
    public $services = null;
    /**
     * @var array predefined services. If null then use all services. Default is null.
     */
    public $predefinedServices = null;
    /**
     * @var boolean whether to use popup window for authorization dialog. Javascript required.
     */
    public $popup = null;
    /**
     * @var string the action to use for dialog destination. Default: the current route.
     */
    public $action = null;
    /**
     * @var boolean include the CSS file. Default is true.
     * If this is set false, you are responsible to explicitly include the necessary CSS file in your page.
     */
    public $assetBundle = 'tprog\\payment\\assets\\PaymentAssetBundle';

    /**
     * Initializes the widget.
     * This method is called by {@link CBaseController::createWidget}
     * and {@link CBaseController::beginWidget} after the widget's
     * properties have been initialized.
     */
    public function init()
    {
        parent::init();
        // Payment component
        /** @var $component \tprog\payment\Payment */
        $component = Yii::$app->get($this->component);
        // Some default properties from component configuration
        if (!isset($this->services)) {
            $this->services = $component->getServices();
        }
        if (is_array($this->predefinedServices)) {
            $_services = [];
            foreach ($this->predefinedServices as $_serviceName) {
                if (isset($this->services[$_serviceName])) {
                    $_services[$_serviceName] = $this->services[$_serviceName];
                }
            }
            $this->services = $_services;
        }
        if (!isset($this->popup)) {
            $this->popup = $component->popup;
        }
        // Set the current route, if it is not set.
        if (!isset($this->action)) {
            $this->action = '/' . Yii::$app->requestedRoute;
        }
    }

    /**
     * Executes the widget.
     * This method is called by {@link CBaseController::endWidget}.
     */
    public function run()
    {
        parent::run();
        echo $this->render('widget', [
            'id'          => $this->getId(),
            'services'    => $this->services,
            'action'      => $this->action,
            'popup'       => $this->popup,
            'assetBundle' => $this->assetBundle,
        ]);
    }
}


