<?php

namespace Speicher210\Fastbill\Api\Service\Customer\Create;

use JMS\Serializer\Annotation as JMS;
use Speicher210\Fastbill\Api\AbstractApiResponse;

/**
 * API response when creating a customer.
 *
 * @method Response getResponse()
 */
class ApiResponse extends AbstractApiResponse
{

    /**
     * The request.
     *
     * @var Request
     *
     * @JMS\Type("Speicher210\Fastbill\Api\Service\Customer\Create\Request")
     * @JMS\SerializedName("REQUEST")
     */
    protected $request;

    /**
     * The response.
     *
     * @var array
     *
     * @JMS\Type("Speicher210\Fastbill\Api\Service\Customer\Create\Response")
     * @JMS\SerializedName("RESPONSE")
     */
    protected $response;
}
