<?php

namespace Speicher210\Fastbill\Test\Api\Service\Subscription;

use Speicher210\Fastbill\Api\Model\Subscription;
use Speicher210\Fastbill\Api\Service\Subscription\Cancel\ApiResponse as CancelApiResponse;
use Speicher210\Fastbill\Api\Service\Subscription\Cancel\Response as CancelResponse;
use Speicher210\Fastbill\Api\Service\Subscription\ChangeArticle\ApiResponse as ChangeArticleApiResponse;
use Speicher210\Fastbill\Api\Service\Subscription\ChangeArticle\RequestData as ChangeArticleRequestData;
use Speicher210\Fastbill\Api\Service\Subscription\ChangeArticle\Response as ChangeArticleResponse;
use Speicher210\Fastbill\Api\Service\Subscription\Create\ApiResponse as CreateApiResponse;
use Speicher210\Fastbill\Api\Service\Subscription\Create\RequestData as CreateRequestData;
use Speicher210\Fastbill\Api\Service\Subscription\Create\Response as CreateResponse;
use Speicher210\Fastbill\Api\Service\Subscription\CreateSecureLink\ApiResponse as CreateSecureLinkApiResponse;
use Speicher210\Fastbill\Api\Service\Subscription\CreateSecureLink\Response as CreateSecureLinkResponse;
use Speicher210\Fastbill\Api\Service\Subscription\DeleteUsageData\ApiResponse as DeleteUsageDataApiResponse;
use Speicher210\Fastbill\Api\Service\Subscription\DeleteUsageData\RequestData as DeleteUsageRequestData;
use Speicher210\Fastbill\Api\Service\Subscription\DeleteUsageData\Response as DeleteUsageDataResponse;
use Speicher210\Fastbill\Api\Service\Subscription\Get\ApiResponse as GetApiResponse;
use Speicher210\Fastbill\Api\Service\Subscription\Get\RequestData as GetRequestData;
use Speicher210\Fastbill\Api\Service\Subscription\Get\Response as GetResponse;
use Speicher210\Fastbill\Api\Service\Subscription\GetUpcomingAmount\ApiResponse as GetUpcomingAmountApiResponse;
use Speicher210\Fastbill\Api\Service\Subscription\GetUpcomingAmount\RequestData as GetUpcomingAmountRequestData;
use Speicher210\Fastbill\Api\Service\Subscription\GetUpcomingAmount\Response as GetUpcomingAmountResponse;
use Speicher210\Fastbill\Api\Service\Subscription\GetUsageData\ApiResponse as GetUsageDataApiResponse;
use Speicher210\Fastbill\Api\Service\Subscription\GetUsageData\RequestData as GetUsageRequestData;
use Speicher210\Fastbill\Api\Service\Subscription\GetUsageData\Response as GetUsageDataResponse;
use Speicher210\Fastbill\Api\Service\Subscription\Postpone\ApiResponse as PostponeApiResponse;
use Speicher210\Fastbill\Api\Service\Subscription\Postpone\Response as PostponeResponse;
use Speicher210\Fastbill\Api\Service\Subscription\Reactivate\ApiResponse as ReactivateApiResponse;
use Speicher210\Fastbill\Api\Service\Subscription\Renew\ApiResponse as RenewApiResponse;
use Speicher210\Fastbill\Api\Service\Subscription\Renew\Response as RenewResponse;
use Speicher210\Fastbill\Api\Service\Subscription\SetAddon\ApiResponse as SetAddonApiResponse;
use Speicher210\Fastbill\Api\Service\Subscription\SetAddon\RequestData as SetAddonRequestData;
use Speicher210\Fastbill\Api\Service\Subscription\SetAddon\Response as SetAddonResponse;
use Speicher210\Fastbill\Api\Service\Subscription\SetUsageData\ApiResponse as SetUsageDataApiResponse;
use Speicher210\Fastbill\Api\Service\Subscription\SetUsageData\RequestData as SetUsageRequestData;
use Speicher210\Fastbill\Api\Service\Subscription\SetUsageData\Response as SetUsageDataResponse;
use Speicher210\Fastbill\Api\Service\Subscription\SubscriptionService;
use Speicher210\Fastbill\Api\Service\Subscription\Update\ApiResponse as UpdateApiResponse;
use Speicher210\Fastbill\Api\Service\Subscription\Update\Response as UpdateResponse;
use Speicher210\Fastbill\Test\Api\Service\AbstractServiceTest;

/**
 * Test for the subscription service.
 */
class SubscriptionServiceTest extends AbstractServiceTest
{

    public function testGetSubscriptions()
    {
        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = $this->getServiceToTest();

        $data = new GetRequestData();
        $apiResponse = $subscriptionService->getSubscriptions($data->getCustomerId(), $data->getExternalCustomerId(),
            $data->getSubscriptionExternalId(), $data->getSubscriptionId());

        $this->assertInstanceOf(GetApiResponse::class, $apiResponse);
        /** @var GetResponse $response */
        $response = $apiResponse->getResponse();
        $this->assertFalse($response->hasErrors());

        $expectedSubscription = new Subscription();
        $expectedSubscription->setSubscriptionId(501982);
        $expectedSubscription->setCustomerId(995443);
        $expectedSubscription->setSubscriptionTitle('title');
        $expectedSubscription->setCancellationDate(new \DateTime('2016-01-28 16:56:22'));
        $this->assertEquals(array($expectedSubscription), $response->getSubscriptions());
    }

    public function testGetSubscriptionsWithoutCancellationDate()
    {
        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = $this->getServiceToTest();

        $data = new GetRequestData();
        $apiResponse = $subscriptionService->getSubscriptions($data->getCustomerId(), $data->getExternalCustomerId(),
            $data->getSubscriptionExternalId(), $data->getSubscriptionId());

        $this->assertInstanceOf(GetApiResponse::class, $apiResponse);
        /** @var GetResponse $response */
        $response = $apiResponse->getResponse();
        $this->assertFalse($response->hasErrors());

        $expectedSubscription = new Subscription();
        $expectedSubscription->setSubscriptionId(501982);
        $expectedSubscription->setCustomerId(995443);
        $expectedSubscription->setSubscriptionTitle('title');

        $this->assertEquals(array($expectedSubscription), $response->getSubscriptions());
    }

    public function testCreateSubscription()
    {
        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = $this->getServiceToTest();

        $data = new CreateRequestData(60, 996423);
        $apiResponse = $subscriptionService->createSubscription($data);

        $this->assertInstanceOf(CreateApiResponse::class, $apiResponse);
        /** @var CreateResponse $response */
        $response = $apiResponse->getResponse();
        $this->assertFalse($response->hasErrors());

        $expectedCreateResponse = new CreateResponse();
        $expectedCreateResponse->setSubscriptionId(503772);
        $expectedCreateResponse->setHash('f0bd1772132b8711650ab2b8623bd575');
        $expectedCreateResponse->setInvoiceId(845277);
        $expectedCreateResponse->setPayPalUrl('https://automatic.fastbill.com/paypal');
        $expectedCreateResponse->setStatus('success');
        $this->assertEquals($expectedCreateResponse, $response);
    }

    public function testUpdateSubscription()
    {
        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = $this->getServiceToTest();

        $apiResponse = $subscriptionService->updateSubscription(503772);

        $this->assertInstanceOf(UpdateApiResponse::class, $apiResponse);
        /** @var UpdateResponse $response */
        $response = $apiResponse->getResponse();
        $this->assertFalse($response->hasErrors());

        $expectedUpdateResponse = new UpdateResponse();
        $expectedUpdateResponse->setStatus('success');
        $this->assertEquals($expectedUpdateResponse, $response);
    }

    public function testChangeSubscriptionArticleAction()
    {
        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = $this->getServiceToTest();

        $data = new ChangeArticleRequestData(503772, 666);
        $apiResponse = $subscriptionService->changeSubscriptionArticle($data);

        $this->assertInstanceOf(ChangeArticleApiResponse::class, $apiResponse);
        /** @var ChangeArticleResponse $response */
        $response = $apiResponse->getResponse();
        $this->assertFalse($response->hasErrors());

        $expectedChangeArticleResponse = new ChangeArticleResponse();
        $expectedChangeArticleResponse->setStatus('success');
        $expectedChangeArticleResponse->setSubscriptionId(503772);

        $this->assertEquals($expectedChangeArticleResponse, $response);
    }

    public function testSetSubscriptionAddonAction()
    {
        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = $this->getServiceToTest();

        $data = new SetAddonRequestData(503772, 666);
        $apiResponse = $subscriptionService->setSubscriptionAddon($data);

        $this->assertInstanceOf(SetAddonApiResponse::class, $apiResponse);
        /** @var SetAddonResponse $response */
        $response = $apiResponse->getResponse();
        $this->assertFalse($response->hasErrors());

        $expectedSetSubscriptionAddonResponse = new SetAddonResponse();
        $expectedSetSubscriptionAddonResponse->setStatus('success');

        $this->assertEquals($expectedSetSubscriptionAddonResponse, $response);

    }

    public function testSetSubscriptionUsageData()
    {
        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = $this->getServiceToTest();

        $data = new SetUsageRequestData(503772, 666);
        $apiResponse = $subscriptionService->setSubscriptionUsageData($data);

        $this->assertInstanceOf(SetUsageDataApiResponse::class, $apiResponse);
        /** @var SetUsageDataResponse $response */
        $response = $apiResponse->getResponse();
        $this->assertFalse($response->hasErrors());

        $expectedSetUsageDataResponse = new SetUsageDataResponse();
        $expectedSetUsageDataResponse->setStatus('success');
        $expectedSetUsageDataResponse->setUsageDataId('1');
        $this->assertEquals($expectedSetUsageDataResponse, $response);
    }

    public function testGetSubscriptionUsageData()
    {
        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = $this->getServiceToTest();

        $data = new GetUsageRequestData(503772);
        $data->setSubscriptionStart(new \DateTime('2015-10-21 00:00:00'));
        $data->setSubscriptionEnd(new \DateTime('2015-11-29 00:00:00'));
        $apiResponse = $subscriptionService->getSubscriptionUsageData($data->getSubscriptionId(),
            $data->getSubscriptionStart(), $data->getSubscriptionEnd());

        $this->assertInstanceOf(GetUsageDataApiResponse::class, $apiResponse);
        /** @var GetUsageDataResponse $response */
        $response = $apiResponse->getResponse();
        $this->assertFalse($response->hasErrors());

        $expectedGetUsageDataResponse = new GetUsageDataResponse();

        $this->assertEquals($expectedGetUsageDataResponse, $response);
    }

    public function testDeleteSubscriptionUsageData()
    {
        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = $this->getServiceToTest();

        $data = new DeleteUsageRequestData('223789');
        $apiResponse = $subscriptionService->deleteSubscriptionUsageData($data->getUsageDataId());

        $this->assertInstanceOf(DeleteUsageDataApiResponse::class, $apiResponse);
        /** @var DeleteUsageDataResponse $response */
        $response = $apiResponse->getResponse();
        $this->assertFalse($response->hasErrors());

        $expectedDeleteUsageDataResponse = new DeleteUsageDataResponse();
        $expectedDeleteUsageDataResponse->setStatus('success');
        $this->assertEquals($expectedDeleteUsageDataResponse, $response);
    }

    public function testGetUpcomingAmount()
    {
        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = $this->getServiceToTest();

        $requestData = new GetUpcomingAmountRequestData();
        $requestData->setArticleNumber('A123');
        $requestData->setCountryCode('DE');
        $requestData->setCoupon('COUPON');
        $apiResponse = $subscriptionService->getUpcomingAmount($requestData);
        $this->assertInstanceOf(GetUpcomingAmountApiResponse::class, $apiResponse);

        /** @var PostponeResponse $response */
        $response = $apiResponse->getResponse();
        $this->assertFalse($response->hasErrors());

        $expectedGetUpcomingAmountResponse = new GetUpcomingAmountResponse();
        $expectedGetUpcomingAmountResponse->setTotal(125);
        $this->assertEquals($expectedGetUpcomingAmountResponse, $response);
    }

    public function testPostponeSubscription()
    {
        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = $this->getServiceToTest();

        $apiResponse = $subscriptionService->postponeSubscription(501982, 6);
        $this->assertInstanceOf(PostponeApiResponse::class, $apiResponse);

        /** @var PostponeResponse $response */
        $response = $apiResponse->getResponse();
        $this->assertFalse($response->hasErrors());

        $expectedPostponeResponse = new PostponeResponse();
        $expectedPostponeResponse->setStatus('success');
        $this->assertEquals($expectedPostponeResponse, $response);
    }

    public function testRenewSubscription()
    {
        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = $this->getServiceToTest();

        $apiResponse = $subscriptionService->renewSubscription(501982);
        $this->assertInstanceOf(RenewApiResponse::class, $apiResponse);

        /** @var RenewResponse $response */
        $response = $apiResponse->getResponse();
        $this->assertFalse($response->hasErrors());

        $expectedRenewResponse = new RenewResponse();
        $expectedRenewResponse->setStatus('success');
        $this->assertEquals($expectedRenewResponse, $response);
    }

    public function testCreateSecureLink()
    {
        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = $this->getServiceToTest();

        $apiResponse = $subscriptionService->createSecureLink(501982);
        $this->assertInstanceOf(CreateSecureLinkApiResponse::class, $apiResponse);

        /** @var CreateSecureLinkResponse $response */
        $response = $apiResponse->getResponse();
        $this->assertFalse($response->hasErrors());

        $expectedCreateSecureLinkResponse = new CreateSecureLinkResponse();
        $expectedCreateSecureLinkResponse->setAddonsUrl('https://test.com/addon');
        $expectedCreateSecureLinkResponse->setCancelUrl('https://test.com/cancel');
        $expectedCreateSecureLinkResponse->setReactivateUrl('https://test.com/reactivate');

        $this->assertEquals($expectedCreateSecureLinkResponse, $response);
    }

    public function testCancelSubscription()
    {
        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = $this->getServiceToTest();

        $apiResponse = $subscriptionService->cancelSubscription(501982);
        $this->assertInstanceOf(CancelApiResponse::class, $apiResponse);

        /** @var CancelResponse $response */
        $response = $apiResponse->getResponse();
        $this->assertFalse($response->hasErrors());

        $expectedCancelResponse = new CancelResponse();
        $expectedCancelResponse->setStatus('success');
        $this->assertEquals($expectedCancelResponse, $response);
    }

    public function testReactivateSubscription()
    {
        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = $this->getServiceToTest();

        $apiResponse = $subscriptionService->reactivateSubscription(501982);
        $this->assertInstanceOf(ReactivateApiResponse::class, $apiResponse);
    }

    /**
     * {@inheritdoc}
     */
    protected function getClassUnderTest()
    {
        return SubscriptionService::class;
    }
}
