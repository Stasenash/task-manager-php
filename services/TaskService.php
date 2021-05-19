<?php

namespace app\services;
use app\models\Task;
use DateTime;
use Yii;

class TaskService {
        public function addTask($type, $title, $description, $status, $executor) {
            $task = new Task();
            $task->type = $type;
            $task->title = $title;
            if ($description != null) {
                $task->description = $description;
            }else {
                $task->description = "";
            }
            $task->status = $status;
            $task->author_id = Yii::$app->user->id;
            $task->executor_id = $executor;
            $task->create_date = Yii::$app->formatter->asDateTime('now', 'yyyy-MM-dd H:i:s');
            $task->save();
        }
    }