<?php

namespace common\services;

use common\interfaces\UserInterface;

class UserService
{
    private $userService;

    public function __construct(UserInterface $userInterface)
    {
        $this->userService = $userInterface;
    }


    public function getPatientsById(int $id)
    {
        return $this->userService->getPatientsById($id);
    }


}