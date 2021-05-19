<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AddTaskForm extends Model
{
    public $title;
    public $type;
    public $description;
    public $executor;
    public $status;


    public function attributeLabels() {
        return [
            'title' => 'Название',
            'type' => 'Тип',
            'description' => 'Описание',
            'executor' => 'Исполнитель',
            'status' => 'Статус',
        ];
    }

    public function rules()
    {
        return [
            [['title', 'type', 'status', 'executor'], 'required'],
        ];
    }
}
