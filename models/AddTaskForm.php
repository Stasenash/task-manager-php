<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 *
 * AddTaskForm is the model behind the add task form.
 *
 */

class AddTaskForm extends Model
{
    public $title;
    public $type;
    public $description;
    public $executor;
    public $status;

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'title' => 'Название',
            'type' => 'Тип',
            'description' => 'Описание',
            'executor' => 'Исполнитель',
            'status' => 'Статус',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title', 'type', 'status', 'executor'], 'required'],
            ['description', 'string'],
        ];
    }
}
