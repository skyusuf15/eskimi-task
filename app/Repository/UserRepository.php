<?php


namespace App\Repository;


use App\Common\ResponseMessages;
use App\Models\User;
use Exception;

class UserRepository
{

    /**
     * @param int $userId
     * @return User
     * @throws Exception
     */
    public function getUserInstance(int $userId): User
    {
        $user =User::find($userId);
        if (!$user){
            throw new Exception(ResponseMessages::INVALID_USER);
        }
        return $user;
    }
}
