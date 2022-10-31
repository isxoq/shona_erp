<?php

namespace common\repositories;

use common\interfaces\UserInterface;
use common\models\User;

class UserRepository implements UserInterface
{

    public function getPatientsById($id)
    {
        $patient = User::find()
            ->andWhere(['id' => $id])
            ->andWhere(['type_id' => User::TYPE_CLIENT])
            ->one();
        return $patient;
    }

}