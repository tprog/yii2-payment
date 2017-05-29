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

/**
 * The Payment class .
 *
 * @package application.extensions.payment
 */
class Payment extends Object
{
    /**
     * @var array Authorization services and their settings.
     */
    protected $services = [];
    /**
     * @var boolean Whether to use popup window for the authorization dialog.
     */
    protected $popup = true;
    /**
     * @var string|bool Cache component name to use. False to disable cache.
     */
    public $cache = null;
    /**
     * @var integer the number of seconds in which the cached value will expire. 0 means never expire.
     */
    public $cacheExpire = 0;
    /**
     * @var string popup redirect view with custom js code
     */
    protected $redirectWidget = '\\tprog\\payment\\RedirectWidget';


    /**
     * Initialize the component.
     */
    public function init()
    {
        parent::init();
        // set default cache on production environments
        if (!isset($this->cache) && YII_ENV_PROD) {
            $this->cache = 'cache';
        }
    }

    /**
     * @param array $services
     */
    public function setServices($services)
    {
        $this->services = $services;
    }

    /**
     * Returns services settings declared in the authorization classes.
     * For perfomance reasons it uses cache to store settings array.
     *
     * @return \stdClass[] services settings.
     */
    public function getServices()
    {
        $services = false;
        if (!empty($this->cache) && Yii::$app->has($this->cache)) {
            /** @var $cache \yii\caching\Cache */
            $cache = Yii::$app->get($this->cache);
            $services = $cache->get('Payment.services');
        }
        if (false === $services || !is_array($services)) {
            $services = [];
            foreach ($this->services as $service => $options) {
                /** @var $class ServiceBase */
                $class = $this->getIdentity($service);
                $services[$service] = (object)[
                    'id'          => $class->getServiceName(),
                    'title'       => $class->getServiceTitle(),
                    'type'        => $class->getServiceType(),
                    'jsArguments' => $class->getJsArguments(),
                ];
            }
            if (isset($cache)) {
                $cache->set('Payment.services', $services, $this->cacheExpire);
            }
        }
        return $services;
    }

    /**
     * @param bool $usePopup
     */
    public function setPopup($usePopup)
    {
        $this->popup = $usePopup;
    }

    /**
     * @return bool
     */
    public function getPopup()
    {
        return $this->popup;
    }

    /**
     * @param string|bool $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return string|bool
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param int $cacheExpire
     */
    public function setCacheExpire($cacheExpire)
    {
        $this->cacheExpire = $cacheExpire;
    }

    /**
     * @return int
     */
    public function getCacheExpire()
    {
        return $this->cacheExpire;
    }

    /**
     * @param string $redirectWidget
     */
    public function setRedirectWidget($redirectWidget)
    {
        $this->redirectWidget = $redirectWidget;
    }

    /**
     * @return string
     */
    public function getRedirectWidget()
    {
        return $this->redirectWidget;
    }



    /**
     * Returns the settings of the service.
     *
     * @param string $service the service name.
     * @return \stdClass the service settings.
     * @throws ErrorException
     */
    protected function getService($service)
    {
        $service = strtolower($service);
        $services = $this->getServices();
        if (!isset($services[$service])) {
            throw new ErrorException(Yii::t('payment', 'Undefined service name: {service}.', ['service' => $service]), 500);
        }
        return $services[$service];
    }


    /**
     * Returns the service identity class.
     *
     * @param string $service the service name.
     * @return IPaymentService the identity class.
     * @throws ErrorException
     */
    public function getIdentity($service)
    {
        $service = strtolower($service);
        if (!isset($this->services[$service])) {
            throw new ErrorException(Yii::t('payment', 'Undefined service name: {service}.', ['service' => $service]), 500);
        }
        $service = $this->services[$service];
        $service['component'] = $this;
        /** @var $identity IPaymentService */
        $identity = Yii::createObject($service);
        return $identity;
    }

    /**
     * Redirects to url. If the authorization dialog opened in the popup window,
     * it will be closed instead of redirect. Set $jsRedirect=true if you want
     * to redirect anyway.
     *
     * @param mixed $url url to redirect. Can be route or normal url. See {@link CHtml::normalizeUrl}.
     * @param boolean $jsRedirect whether to use redirect while popup window is used. Defaults to true.
     * @param array $params
     */
    public function redirect($url, $jsRedirect = true, $params = [])
    {
        /** @var RedirectWidget $widget */
        $widget = Yii::createObject([
            'class'    => $this->redirectWidget,
            'url'      => Url::to($url),
            'redirect' => $jsRedirect,
            'params'   => $params,
        ]);
        ob_start();
        $widget->run();
        $output = ob_get_clean();
        $response = Yii::$app->getResponse();
        $response->content = $output;
        $response->send();
        exit();
    }

}


