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
            if (!isset($description)) {
                $task->description = "";
            }else {
                $task->description = $description;
            }
            $task->status = $status;
            $task->author_id = Yii::$app->user->id;
            $task->executor_id = $executor;
            $task->create_date = Yii::$app->formatter->asDateTime('now', 'yyyy-MM-dd H:i:s');
            $task->save();
        }

    public function updateTask($id,$type, $title, $description, $status, $executor) {
        $task = $this->findById($id);
        $task->type = $type;
        $task->title = $title;
        if (!isset($description)) {
            $task->description = "";
        }else {
            $task->description = $description;
        }
        $task->status = $status;
        $task->executor_id = $executor;
        $task->save();
    }

    public function deleteTask($id) {
        $task = $this->findById($id);
        if (isset($task)) {
            $task->delete();
        }
    }

    public function findById($id) {
        $task = Task::find()
            ->where(['id' => $id])
            ->one();
        return $task;
    }

    public function findByTitle($title) {
        $tasks = Task::find()
            ->andWhere(['like', 'title', $title])
            ->all();
        return $tasks;
    }
}