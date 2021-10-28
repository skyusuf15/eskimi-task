<?php

namespace Tests\Unit\app\Services;

use App\Common\ResponseMessages;
use App\Models\Advert;
use App\Models\User;
use App\Repository\AdvertRepository;
use App\Repository\UserRepository;
use App\Services\AdvertService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class AdvertServiceTest extends TestCase
{
    protected AdvertRepository|MockObject $advertRepository;
    protected UserRepository|MockObject $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->advertRepository = $this->createMock(AdvertRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
    }

    public function testGetAllAdvertWhenUserIsNotFound()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(ResponseMessages::INVALID_USER);

        $this->userRepository->method('getUserInstance')->willThrowException(new Exception(ResponseMessages::INVALID_USER));

        $stub = new AdvertService(advertRepository: $this->advertRepository, userRepository: $this->userRepository);
        $stub->getAllAdvert(432);
    }

    public function testGetAllAdvertWhenReturnsEmptyResponse()
    {
        $collection = new Collection([]);
        $userId = 1;

        $this->userRepository->method('getUserInstance')->willReturn($this->mockUser());
        $this->advertRepository->method('getAllAdvert')->willReturn($collection);

        $stub = new AdvertService(advertRepository: $this->advertRepository, userRepository: $this->userRepository);

        $response = $stub->getAllAdvert(userId: $userId);
        $this->assertEquals(expected: $collection->toArray(), actual: $response);
    }

    public function testGetAllAdvertWhenReturnsValidResponse()
    {
        $collection = new Collection([
            $this->mockAdvert(), $this->mockAdvert()
        ]);
        $this->userRepository->method('getUserInstance')->willReturn($this->mockUser());

        $this->advertRepository->method('getAllAdvert')->willReturn($collection);

        $stub = new AdvertService(advertRepository: $this->advertRepository, userRepository: $this->userRepository);

        $response = $stub->getAllAdvert(userId: 1);
        $this->assertEquals(expected: $collection->toArray(), actual: $response);
    }

    public function testUpsertWhenUserIsNotFound()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(ResponseMessages::INVALID_USER);

        $this->userRepository->method('getUserInstance')->willThrowException(new Exception(ResponseMessages::INVALID_USER));

        $stub = new AdvertService(advertRepository: $this->advertRepository, userRepository: $this->userRepository);
        $stub->upsert(name: 'test', from: '23-3-1232', to: '23-3-1239', totalBudget: 3222.21, dailyBudget: 434344.43, userId: 1);
    }

    public function testUpsertWhenCreateAdvert()
    {
        $advert = new Advert($this->mockAdvert());

        $this->userRepository->method('getUserInstance')->willReturn($this->mockUser());
        Storage::shouldReceive('putFile')->andReturn('banner/images/dhjsdhufjbuidfsdkfs.png');
        $this->advertRepository->expects($this->once())->method('createAdvert')->willReturn($advert);

        $stub = new AdvertService(advertRepository: $this->advertRepository, userRepository: $this->userRepository);
        $response = $stub->upsert(name: 'test', from: '23-3-1232', to: '23-3-1239', totalBudget: 3222.21, dailyBudget: 434344.43, userId: 1, files: $this->mockFiles());

        $this->assertEquals(expected: $advert->toArray(), actual: $response);

    }

    public function testUpsertWhenUpdateAdvert()
    {
        $advert = new Advert();
        $advert->id = 1;
        $advert->banner_image_path = "[]";

        $this->userRepository->method('getUserInstance')->willReturn($this->mockUser());
        Storage::shouldReceive('putFile')->andReturn('banner/images/dhjsdhufjbuidfsdkfs.png');
        $this->userRepository->method('getUserInstance')->willReturn($this->mockUser());

        $this->advertRepository->expects($this->never())->method('createAdvert');
        $this->advertRepository->expects($this->once())->method('getAdvertInstance')->willReturn($advert);
        $this->advertRepository->expects($this->once())->method('updateAdvert')->willReturn(true);

        $stub = new AdvertService(advertRepository: $this->advertRepository, userRepository: $this->userRepository);
        $response = $stub->upsert(name: 'test', from: '23-3-1232', to: '23-3-1239', totalBudget: 3222.21, dailyBudget: 434344.43, userId: 1, files: $this->mockFiles(), id: 1);

        $expected = ["message" => "Advertisement updated successfully"];

        $this->assertEquals(expected: $expected, actual: $response);
    }

    public function testUpsertWhenUpdateAdvertReturnFalse()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Failed to save or update record");

        $advert = new Advert();
        $advert->id = 1;
        $advert->banner_image_path = "[]";

        $this->userRepository->method('getUserInstance')->willReturn($this->mockUser());
        Storage::shouldReceive('putFile')->andReturn('banner/images/dhjsdhufjbuidfsdkfs.png');
        $this->userRepository->method('getUserInstance')->willReturn($this->mockUser());

        $this->advertRepository->expects($this->never())->method('createAdvert');
        $this->advertRepository->expects($this->once())->method('getAdvertInstance')->willReturn($advert);
        $this->advertRepository->expects($this->once())->method('updateAdvert')->willReturn(false);

        $stub = new AdvertService(advertRepository: $this->advertRepository, userRepository: $this->userRepository);
        $stub->upsert(name: 'test', from: '23-3-1232', to: '23-3-1239', totalBudget: 3222.21, dailyBudget: 434344.43, userId: 1, files: $this->mockFiles(), id: 1);
    }

    /**
     * @return User
     */
    private function mockUser(): User
    {
        return new User([
            "id" => 1,
            "name" => "test name"
        ]);
    }

    /**
     * @return array
     */
    private function mockAdvert(): array
    {
        return [
            "id" => 1,
            "name" => "test ads",
            "from" => "2021-02-12",
            "to" => "2021-08-12",
            "total_budget" => 43543.32,
            "daily_budget" => 435.10,
            "banner_image_path" => "[]",
        ];
    }

    /**
     * @return array
     */
    private function mockFiles(): array
    {
        return [UploadedFile::fake()->createWithContent(name: 'banner1.png', content: 'random content'), UploadedFile::fake()->createWithContent(name: 'banner2.png', content: 'random content')];
    }
}
