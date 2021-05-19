<?php

namespace app\services;
use app\models\Type;

class TypeService {
    public function findById($id) {
        return Type::find()
            ->where(['id' => $id])
            ->one();
    }

    public function findByName($name)
    {
        return Type::find()
            ->where(['name' => $name])
            ->one();
    }
}