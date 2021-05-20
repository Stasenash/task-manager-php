<?php

namespace app\services;
use app\models\User;
use Yii;
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

    /**
     *
     * Create and save user to db.
     *
     */
    public function addUser($login, $email, $password)
    {
        $user = new User();
        $user->login = $login;
        $user->email = $email;
        $user->password = $password;
        $user->create_date = Yii::$app->formatter->asDateTime('now', 'yyyy-MM-dd H:i:s');

        $user->save();
    }
}