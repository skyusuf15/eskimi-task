<?php


namespace App\Services;

use App\Repository\AdvertRepository;
use App\Repository\UserRepository;
use Exception;
use Illuminate\Support\Facades\Storage;

class AdvertService
{
    /**
     * AdvertService constructor.
     * @param AdvertRepository $advertRepository
     * @param UserRepository $userRepository
     */
    public function __construct(private AdvertRepository $advertRepository, private UserRepository $userRepository)
    {
    }

    /**
     * @param string $name
     * @param string $from
     * @param string $to
     * @param float $totalBudget
     * @param float $dailyBudget
     * @param int $userId
     * @param array $files
     * @param int|null $id
     * @return array
     * @throws Exception
     */
    public function upsert(string $name, string $from, string $to, float $totalBudget, float $dailyBudget,  int $userId, array $files = [], int $id = null): array
    {
        $user = $this->userRepository->getUserInstance(userId: $userId);

        $bannerArray = [];
        foreach ($files as $image) {
            $bannerArray[] = Storage::putFile('public/banners', $image);
        }

        $payload = [
            "user_id" => $user->id,
            "name" => $name,
            "from" => $from,
            "to" => $to,
            "total_budget" => $totalBudget,
            "daily_budget" => $dailyBudget,
            "banner_image_path" => json_encode($bannerArray),
        ];

        if (is_null($id)) return $this->advertRepository->createAdvert(payload: $payload)->toArray();

        $advert = $this->advertRepository->getAdvertInstance(advertId: $id);

        $payload['banner_image_path'] = array_merge(json_decode($payload['banner_image_path']), json_decode($advert->banner_image_path));
        if ($this->advertRepository->updateAdvert(advertId: $advert->id, payload: $payload)){
            return ["message" => "Advertisement updated successfully"];
        }

        throw new Exception(message: "Failed to save or update record");
    }

    /**
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public function getAllAdvert(int $userId): array
    {
        $user = $this->userRepository->getUserInstance(userId: $userId);
        return $this->advertRepository->getAllAdvert($user)->toArray();
    }
}
