<?php

namespace app\services;
use app\models\Type;

class TypeService {
    public function findById($id) {
        return Type::find()
            ->where(['id' => $id])
            ->one();
    }
}