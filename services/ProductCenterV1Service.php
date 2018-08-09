<?php
namespace SLD\PPNServicesSDK;

class ProductCenterV1Service extends BaseService
{

    private static $instance = null;
    const SUCCESS_CODE = 200;

    public function __construct()
    {
        parent::__construct();
        $this->host = $this->config['host'];
    }

    /**
     * @return object instance of ProductCenterV1Service
     */
    public static function getInstance()
    {
        if (!self::$instance || !(self::$instance instanceof self)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * deal with romote services response
     * @param $response
     *
     * @return array/boolean
     */
    protected function dealResponse($response)
    {
        if (isset($response['code']) && $response['code'] === self::SUCCESS_CODE) {
            return $response['data'];
        } else {
            $this->setErrorMessage($response);
            return false;
        }
    }

    public function getProductList()
    {
        $query = '';
        $response = $this->httpBuilder([
            'path' => '/product/list',
            'query' => $query,
            'method' => 'get',
        ]);
        return $this->dealResponse($response);
    }
}
