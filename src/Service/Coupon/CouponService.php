<?php

namespace Speicher210\Fastbill\Api\Service\Coupon;

use Speicher210\Fastbill\Api\AbstractService;

/**
 * Service for coupon.
 */
class CouponService extends AbstractService
{

    /**
     * Get the coupons.
     *
     * @param string $code The code to get.
     * @return Get\ApiResponse
     */
    public function getCoupons($code = null)
    {
        $requestData = new Get\RequestData($code);
        $request = new Get\Request($requestData);

        $apiResponse = $this->sendRequest($request, Get\ApiResponse::class);
        /** @var Get\Response $response */
        $response = $apiResponse->getResponse();
        foreach ($response->getCoupons() as $coupon) {
            $validFrom = $coupon->getValidFrom();
            if ($validFrom !== null) {
                $validFrom->setTime(0, 0, 0);
            }

            $validTo = $coupon->getValidTo();
            if ($validTo !== null) {
                $validTo->setTime(0, 0, 0);
            }
        }


        return $apiResponse;
    }

    /**
     * Check a coupon.
     *
     * @param string $code The code to check.
     * @return Check\ApiResponse
     */
    public function checkCoupon($code)
    {
        $requestData = new Check\RequestData($code);
        $request = new Check\Request($requestData);

        return $this->sendRequest($request, Check\ApiResponse::class);
    }
}
