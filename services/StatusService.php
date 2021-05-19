<?php

namespace app\services;
use app\models\Status;

class StatusService {
    public function findById($id) {
        return Status::find()
            ->where(['id' => $id])
            ->one();
    }
}