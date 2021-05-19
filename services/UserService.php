<?php

namespace app\services;
use app\models\Task;
use app\models\User;
use Yii;

class UserService {

    public function findById($id)
    {
        return User::find()
                ->where(['id'=> $id])
                ->one();
    }
}