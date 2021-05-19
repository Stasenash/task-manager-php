<?php

namespace app\services;
use app\models\User;
use yii\db\ActiveRecord;

/**
 *
 * UserService is the service for work with User ActiveRecord.
 *
 */
class UserService {
    /**
     * Find and return user by id from db.
     *
     * @return User|ActiveRecord
     */
    public function findById($id)
    {
        return User::find()
                ->where(['id'=> $id])
                ->one();
    }
}