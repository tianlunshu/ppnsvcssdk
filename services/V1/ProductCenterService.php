<?php
namespace SLD\PPNServicesSDK\V1;

use SLD\PPNServicesSDK\ProductCenterV1Service;

class ProductCenterService extends ProductCenterV1Service
{
    /**
     * get products detail url
     * @param $productIds
     *
     * @return array
     */
    public function getProductsUrl(array $productIds)
    {
        if (empty($productIds)) {
            $this->setErrorMessage('product ids is empty');
            return false;
        }
        $response = $this->httpBuilder([
            'path'   => '/v1/productsUrl',
            'method' => 'post',
            'body'   => json_encode(compact('productIds'))
        ]);
        return $this->dealResponse($response);
    }

    /**
     * get products display price
     * @param $productIds
     * @param $date
     * @param $currency
     * @param $platform
     *
     * @return array
     */
    public function getProductsDisplayPrice(array $productIds, $date='', $currency='usd', $platform='pc')
    {
        if (empty($productIds)) {
            $this->setErrorMessage('product ids is empty');
            return false;
        }
        $remoteUrl = '/v1/productsDisplayPrice?'.http_build_query(compact('currency', 'platform'));

        $response = $this->httpBuilder([
            'path'   => $remoteUrl,
            'method' => 'post',
            'body'   => json_encode(compact('productIds', 'date'))
        ]);

        return $this->dealResponse($response);
    }

    /**
     * [getUpgrades 获取产品升级项目(get product upgrades)]
     * @param  array   $productIds     [产品ID]
     * @param  [type]  $departure_date [出团日期，酒店传的是数组eg:['checkin_date', 'checkout_date'],其他产品线为departure_date]
     * @param  string  $purchase_date   [购买日期]
     * @param  string  $currency       [目标币种]
     * @param  integer $noCache        [是否走缓存，0：走，1：不走]
     * @return [type]                  [description]
     */
    public function getUpgrades(array $productIds, $departure_date, $purchase_date = '', $currency = 'USD', $noCache = 0)
    {
        if (empty($productIds)) {
            $this->setErrorMessage('product ids is empty');
            return false;
        }
        $remoteUrl = '/v1/upgrades';

        $response = $this->httpBuilder([
            'path'   => $remoteUrl,
            'method' => 'post',
            'body'   => json_encode(compact('productIds', 'departure_date', 'purchase_date', 'currency', 'noCache'))
        ]);

        return $this->dealResponse($response);
    }


    /**
     * Update/Delete/Add similar products
     * 更新、添加、删除个别相似产品id时，传入最新的相似产品id字符串, id之间以  ，分割
     * 如123,456,789
     * 删除所有相似产品时，传入空字符串 ""
     *
     * @param integer $product_id Product Id i.e.:product_id1
     * @param string  $similarIds Product Ids "product_id1,product_id2,..."
     *
     * @return array|bool  {
     *      ["code"]=> int(0)
     *      ["message"]=> string(7) "success"
     *      ["time_spend"]=> float(0.3356)
     *      ["data"]=> array(1) {
     *           ["success"]=> string(32) "insert 13362,13365,13368 success"
     *      }
     * }
     */
    public function updateSimilarProducts($productId, $similarIds){
        if (empty($productId)) {
            $this->setErrorMessage('productId is empty');
            return false;
        }
        $remoteUrl = '/edit/updateSimilarProducts';

        $response = $this->httpBuilder([
            'path'    =>  $remoteUrl,
            'method'  =>  'post',
            'body'    =>  json_encode(compact('productId','similarIds'))
        ]);

        return $this->dealResponse($response);
    }


    /**
     * get product additional info， 获取多日游，组合团产品酒店延住信息
     * @param $productId
     * @param $aheadArriveDate eg : ["2018-02-01", "2018-02-03"]
     * @param $delayLeaveDate eg : ["2018-02-08", "2018-02-11"]
     * @param $roomInfo eg :
     *[
     *   {
     *       "adult":2,
     *       "child":1
     *   },
     *   {
     *       "adult":1,
     *       "child":2
     *   }
     *
     *]
     * @return array
     */
    public function getProductAdditional($productId, array $aheadArriveDate, array $delayLeaveDate, array $roomInfo)
    {
        if (!is_numeric($productId) || !$productId || empty($aheadArriveDate) || empty($delayLeaveDate) || empty($roomInfo)) {
            $this->setErrorMessage('params error');
            return false;
        }
        $requestBody = json_encode([
            'product_id'        => $productId,
            'ahead_arrive_date' => $aheadArriveDate,
            'delay_leave_date'  => $delayLeaveDate,
            'room_info'         => $roomInfo
        ]);

        $response = $this->httpBuilder([
            'path'   => '/v1/additional',
            'method' => 'post',
            'body'   => $requestBody
        ]);

        return $this->dealResponse($response);
    }

    /**
     * [get hotels availability room price by condition 通过各个酒店产品的入住条件获取可用的房型]
     * @param  array   $condition [条件]
     * $condition = [
            [
                'product_id' => 102202254,
                'checkin_date' => '2017-07-13',
                'checkout_date' => '2017-07-14',
                'customer_info' => '1,2,9,8',
                'currency' => 'USD'
            ],
            [
                'product_id' => 101465580,
                'checkin_date' => '2017-07-13',
                'checkout_date' => '2017-07-14',
                'customer_info' => '1,2,9,8',
                'currency' => 'USD'
            ]
        ];
     * @param  integer $noCache   [是否走缓存]
     * @return [array]             [description]
     * {
            "101465580": {
                "14838031": {
                    "2017-07-13": {
                        "date": "2017-07-13",
                        "price": "84.00",
                        "price_cost": "75.36"
                    },
                    "currency": "USD"
                },
                "14838032": {
                    "2017-07-13": {
                        "date": "2017-07-13",
                        "price": "96.00",
                        "price_cost": "87.92"
                    },
                    "currency": "USD"
                }
            },
            "102202254": []
        }
     */
    public function getHotelsAvailabilityRoomPriceByCondition(array $condition, $noCache = 0)
    {
        if (empty($condition)) {
            $this->setErrorMessage('condition is empty');
            return false;
        }
        $remoteUrl = '/v1/hotel/hotelsAvailabilityRoomPriceByCondition';

        $response = $this->httpBuilder([
            'path'   => $remoteUrl,
            'method' => 'post',
            'body'   => json_encode(compact('condition', 'noCache'))
        ]);

        return $this->dealResponse($response);
    }


}
