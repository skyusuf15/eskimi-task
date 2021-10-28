<?php


namespace App\Repository;


use App\Common\ResponseCodes;
use App\Common\ResponseMessages;
use App\Models\Advert;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class AdvertRepository
{
    /**
     * @param int $advertId
     * @return Advert
     * @throws Exception
     */
    public function getAdvertInstance(int $advertId): Advert
    {
        $advert = Advert::find($advertId);
        if (!$advert) {
            throw new Exception(message: ResponseMessages::INVALID_ADVERT, code: ResponseCodes::BAD_REQUEST);
        }
        return $advert;
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getAllAdvert(User $user): Collection
    {
        return Advert::where('user_id', $user->id)->get();
    }

    /**
     * @param array $payload
     * @return Advert
     */
    public function createAdvert(array $payload): Advert
    {
        return Advert::create($payload);
    }

    /**
     * @param int $advertId
     * @param array $payload
     * @return bool
     */
    public function updateAdvert(int $advertId, array $payload): bool
    {
        return Advert::where('id', $advertId)->update($payload);
    }
}
