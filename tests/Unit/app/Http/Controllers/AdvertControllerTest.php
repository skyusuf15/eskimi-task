<?php

namespace Tests\Unit\app\Http\Controllers;

use App\Common\ResponseMessages;
use App\Http\Controllers\AdvertController;
use App\Http\Requests\AdvertRequest;
use App\Services\AdvertService;
use Exception;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class AdvertControllerTest extends TestCase
{
    protected AdvertService|MockObject $advertService;

    public function setUp(): void
    {
        parent::setUp();
        $this->advertService = $this->createMock(AdvertService::class);
    }

    public function testIndexWhenGetAllAdvertThrowsException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(ResponseMessages::INVALID_USER);

        $this->advertService->method('getAllAdvert')->willThrowException(new Exception(ResponseMessages::INVALID_USER));

        $stub = new AdvertController($this->advertService);
        $stub->index(userId: 1);
    }

    public function testIndexWhenGetAllAdvertReturnsEmptyResponse()
    {
        $responseArray = [];
        $this->advertService->method('getAllAdvert')->willReturn($responseArray);

        $stub = new AdvertController($this->advertService);

        $response = $stub->index(userId: 1);

        $this->assertObjectHasAttribute('status', $response->getData());
        $this->assertObjectHasAttribute('data', $response->getData());
        $this->assertEquals($this->getMockResponse($responseArray), $response->getData());
    }

    public function testIndexWhenGetAllAdvertReturnsValidResponse()
    {
        $responseArray = [
            [
                "id" => 1,
                "name" => "test ads",
                "from" => "2021-02-12",
                "to" => "2021-08-12",
                "total_budget" => 43543.32,
                "daily_budget" => 435.10,
                "banner_image_path" => "[]",
            ]
        ];
        $this->advertService->method('getAllAdvert')->willReturn($responseArray);

        $stub = new AdvertController($this->advertService);

        $response = $stub->index(userId: 1);

        $this->assertObjectHasAttribute('status', $response->getData());
        $this->assertObjectHasAttribute('data', $response->getData());
        $this->assertEquals(json_encode($this->getMockResponse($responseArray)), json_encode($response->getData()));
    }

    public function testCreateOrUpdateWhenUpsertThrowsException()
    {
        $message = "Failed to save or update record";
        $this->expectException(Exception::class);
        $this->expectExceptionMessage($message);

        $this->advertService->method('upsert')->willThrowException(new Exception($message));

        $stub = new AdvertController($this->advertService);
        $stub->createOrUpdate(request: $this->getRequestMock());
    }

    public function testCreateOrUpdateWhenSuccess()
    {
        $responseArray = [
            "id" => 1,
            "name" => "test21",
            "from" => "2021-02-12",
            "to" => "2021-08-12",
            "total_budget" => 43543.32,
            "daily_budget" => 4385.10,
            "banner_image_path" => "[]",
        ];
        $this->advertService->method('upsert')->willReturn($responseArray);

        $stub = new AdvertController(advertService: $this->advertService);
        $response = $stub->createOrUpdate(request: $this->getRequestMock());


        $this->assertObjectHasAttribute('status', $response->getData());
        $this->assertObjectHasAttribute('data', $response->getData());
        $this->assertEquals(json_encode($this->getMockResponse($responseArray)), json_encode($response->getData()));
    }


    private function getMockResponse($data): object
    {
        return (object)[
            'status' => 'success',
            'data' => $data
        ];
    }

    private function getRequestMock(): Request
    {
        return new AdvertRequest([
            "user_id" => 1,
            'name' => "test",
            'from' =>  "2021-08-22",
            'to' =>  "2021-08-30",
            'total_budget' =>  43353533.21,
            'daily_budget' => 43353.21,
            'banners' => [],
        ]);
    }
}
