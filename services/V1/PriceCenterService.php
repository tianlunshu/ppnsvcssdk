<?php
namespace SLD\PPNServicesSDK\V1;

use SLD\PPNServicesSDK\BaseService;
use SLD\PPNServicesSDK\FinanceService;

class PriceCenterService extends BaseService
{

    private $_rateInfo = []; // 储存费率信息

    private $currencySymbolMaps = array (
        'USD' => '$',
        'GBP' => '£',
        'AUD' => 'AUD',//'$A.',
        'NZD' => 'NZD',//'$NZ.',
        'EUR' => '€',
        'CAD' => 'C$',
        'CNY' => '¥',
        'HKD' => 'HK$',
        'RUB' => 'руб',
        'KRW' => '₩',
        'SUR' => 'py6',
        'JPY' => '¥',
        'ZAR' => 'R',
        'NOK' => 'kr',
        'PHP' => '₱',
        'SEK' => 'kr',
        'CHF' => 'Fr',
        'DKK' => 'kr',
    );

    private $currencyNameMaps = array (
        'USD' => '美元',
        'GBP' => '英镑',
        'AUD' => '澳元',
        'NZD' => '新西兰元',
        'EUR' => '欧元',
        'CAD' => '加元',
        'CNY' => '人民币',
        'HKD' => '港元',
        'RUB' => '卢布',
        'KRW' => '韩元',
        'SUR' => '卢布',
        'JPY' => '日元',
        'ZAR' => '南非南特',
        'NOK' => '挪威克朗',
        'PHP' => '比索',
        'SEK' => '瑞典克朗',
        'CHF' => '法郎',
        'DKK' => '丹麦克朗',
    );

    private static $instance = null;
    const SUCCESS_CODE = 0;

    public function __construct()
    {
        parent::__construct();
        $this->host = $this->config[ 'host' ];
    }

    /**
     * @return object instance of ProductCenterV1Service
     */
    public static function getInstance()
    {
        if (! self::$instance || ! (self::$instance instanceof self)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Description: 通过币种代号 获取货币符号
     *
     * @param string $currencyCode
     *
     * @return mixed|string
     *
     * @author: Bililovy
     * @date  : 2017/10/30 15:32
     */
    public function getCurrencySymbol($currencyCode = '')
    {
        $currencyCode = strtoupper($currencyCode);
        if (isset($this->currencySymbolMaps[ $currencyCode ])) {
            return $this->currencySymbolMaps[ $currencyCode ];
        }

        return '';
    }

    /**
     * Description: 根据币种代号 获取币种中文名称
     *
     * @param string $currencyCode
     *
     * @return string
     *
     * @author: Bililovy
     * @date  : 2017/10/30 15:33
     */
    public function getCurrencySymbolName($currencyCode = '')
    {
        $currencyCode = strtoupper($currencyCode);
        if (isset($this->currencyNameMaps[ $currencyCode ])) {
            $name = $this->currencyNameMaps[ $currencyCode ];
        } else {
            $name = $currencyCode;
        }

        return $name;
    }

    /**
     * Description: 外部调用，转换单个价格币种
     *
     * @param number $price          这里至传入金额，不支持数组
     * @param string $sourceCurrency 原始币种
     * @param string $targetCurrency 目标币种
     * @param int $priceLevel        金额小数点保留
     * @param string $date           汇率读取日期，可不传，默认当前实时时间
     *
     * @return string
     *
     * @author: Bililovy
     * @date  : 2017/10/30 15:55
     */
    public function exchangeCurrency($price, $sourceCurrency = '', $targetCurrency = '', $priceLevel = 4, $date = '')
    {
        return $this->doExchangeCurrency($price, $sourceCurrency, $targetCurrency, $priceLevel, $date);
    }

    /**
     * Description: 批量进行价格币种转换，支持无限极币种转换，数组格式不做限制
     *
     * @param array $priceArray
     * @param array $exchangeKeys
     * @param string $sourceCurrency
     * @param string $targetCurrency
     * @param int $priceLevel
     * @param string $date
     *
     * @return array
     *
     * @author: Bililovy
     * @date  : 2017/10/30 16:01
     */
    public function exchangeCurrencyBatch(array $priceArray, $exchangeKeys = array (), $sourceCurrency = '', $targetCurrency = '', $priceLevel = 4, $date = '')
    {
        if (empty($priceArray) || ! is_array($priceArray)) {
            return $priceArray;
        }

        foreach ($priceArray as $keyAmount => & $amount) {
            if (is_array($amount)) {
                if (! empty($amount)) {
                    $amount = $this->exchangeCurrencyBatch($amount, $exchangeKeys, $sourceCurrency, $targetCurrency, $priceLevel, $date);
                }
            } else {
                if (! empty($exchangeKeys) && in_array($keyAmount, $exchangeKeys, true)) {
                    $amount = $this->doexchangeCurrency($amount, $sourceCurrency, $targetCurrency, $priceLevel, $date);
                }
            }
        }

        unset($amount);

        return $priceArray;
    }

    /**
     * get products basic info
     *
     * @param $productIds
     * @param $returnFields , product fields default all
     * @param $noCache
     *
     * @return array/boolean
     */
    public function getPriceInfos(array $productIds, array $returnFields = array (), array $conditions = array (), $noCache = 0)
    {
        if (empty($productIds)) {
            $this->setErrorMessage('product ids is empty');

            return false;
        }

        $response = $this->httpBuilder([
            'path' => '/v1/price',
            'method' => 'post',
            'body' => json_encode(compact('noCache', 'productIds', 'returnFields', 'conditions'))
        ]);

        return $this->dealResponse($response);
    }

    /**
     * Description: 获取产品指定的可用优惠策略（策略名称用参数指定）
     *
     * @param array $returnFields
     * @param array $conditions
     * @param int $noCache
     *
     * @return array|bool
     *
     * @author: Bililovy
     * @date  : 2017/10/16 17:46
     */
    public function getPolicies(array $returnFields = array (), array $conditions = array (), $noCache = 0)
    {
        if (empty($returnFields)) {
            $this->setErrorMessage('policy type is empty');

            return false;
        }

        $response = $this->httpBuilder([
            'path' => '/v1/policy',
            'method' => 'post',
            'body' => json_encode(compact('noCache', 'returnFields', 'conditions'))
        ]);

        return $this->dealResponse($response);
    }

    /**
     * Description: 币种转换的核心算法
     *
     * @param number $price          初始金额
     * @param string $sourceCurrency 原币种
     * @param string $targetCurrency 目标币种
     * @param int $priceLevel        保留金额的小数点位数
     * @param string $date           汇率日期（默认可不传，则读取实时汇率）
     *
     * @return string
     *
     * @author: Bililovy
     * @date  : 2017/10/30 15:48
     */
    private function doExchangeCurrency($price, $sourceCurrency, $targetCurrency, $priceLevel, $date = '')
    {
        if (! is_numeric($price) || empty($sourceCurrency) || empty($targetCurrency)) {
            return round(number_format($price, $priceLevel, '.', ''), $priceLevel);
        }
        $sourceCurrency = strtoupper($sourceCurrency);
        $targetCurrency = strtoupper($targetCurrency);
        if ($sourceCurrency === $targetCurrency) {
            return round(number_format($price, $priceLevel, '.', ''), $priceLevel);
        }

        $rateInfo = $this->getExchangeRate($date);
        if (empty($rateInfo)) {
            return round(number_format($price, $priceLevel, '.', ''), $priceLevel);
        }

        // return the origin amount if the currency is not support
        if (! isset($rateInfo[ $sourceCurrency ]) || ! isset($rateInfo[ $targetCurrency ])) {
            return round(number_format($price, $priceLevel, '.', ''), $priceLevel);
        }

        $rateFrom = $rateInfo[ $sourceCurrency ];
        $rateTo = $rateInfo[ $targetCurrency ];
        if ($sourceCurrency == 'USD') {
            $price = $price * $rateTo;
        } else {
            $price = ($price / $rateFrom) * $rateTo;
        }

        return round(number_format($price, $priceLevel, '.', ''), $priceLevel);
    }

    /**
     * Description: 获取费率信息
     *
     * @param string $date
     *
     * @return mixed
     *
     * @author: Bililovy
     * @date  : 2017/10/30 15:40
     */
    private function getExchangeRate($date = '')
    {
        if (empty($date)) {
            $date = date("Y-m-d H:i:s");
        }

        if (! isset($this->_rateInfo[ $date ]) || ! $this->_rateInfo[ $date ] || empty($this->_rateInfo[ $date ])) {
            $rate = FinanceService::getInstance();
            $rateInfo = $rate->getRate($date);
            if ($rateInfo[ 'code' ] == 0) {
                $this->_rateInfo[ $date ] = $rateInfo[ 'data' ][ 'rate' ];
            } else {
                $this->_rateInfo[ $date ] = false;
            }
            unset($rate);
            unset($rateInfo);
        }

        return $this->_rateInfo[ $date ];
    }

    /**
     * deal with romote services response
     *
     * @param $response
     *
     * @return array/boolean
     */
    protected function dealResponse($response)
    {
        if (isset($response[ 'code' ]) && intval($response[ 'code' ]) === self::SUCCESS_CODE) {
            return $response[ 'data' ];
        } else {
            $this->setErrorMessage($response);

            return false;
        }
    }

}
