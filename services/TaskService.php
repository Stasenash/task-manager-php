<?php

namespace app\services;
use app\models\Task;
use Yii;
use yii\db\ActiveRecord;

/**
 *
 * TaskService is the service for work with Task ActiveRecord.
 *
 */
class TaskService {
    /**
     *
     * Create and save task to db.
     *
     */
    public function addTask($type, $title, $description, $status, $executor) {
        $task = new Task();
        $task->type = $type;
        $task->title = $title;
        $task->status = $status;
        $task->author_id = Yii::$app->user->id;
        $task->executor_id = $executor;
        $task->create_date = Yii::$app->formatter->asDateTime('now', 'yyyy-MM-dd H:i:s');

        if (!isset($description)) {
            $task->description = "";
        }else {
            $task->description = $description;
        }

        $task->save();
    }

    /**
     *
     * Update and save task to db.
     *
     */
    public function updateTask($id,$type, $title, $description, $status, $executor) {
        $task = $this->findById($id);
        $task->type = $type;
        $task->title = $title;
        $task->status = $status;
        $task->executor_id = $executor;

        if (!isset($description)) {
            $task->description = "";
        }else {
            $task->description = $description;
        }

        $task->save();
    }

    /**
     *
     * Delete task from db.
     *
     */
    public function deleteTask($id) {
        $task = $this->findById($id);
        if (isset($task)) {
            $task->delete();
        }
    }

    /**
     * Find and return task by id from db.
     *
     * @return Task|ActiveRecord
     */
    public function findById($id) {
        return Task::find()
            ->where(['id' => $id])
            ->one();
    }

    /**
     * Find and return tasks by name from db.
     *
     * @return Task|ActiveRecord[]
     */
    public function findByTitle($title) {
        return Task::find()
            ->andWhere(['like', 'title', $title])
            ->all();
    }

    /**
     * Find and return tasks by filter field and expected value from db.
     *
     * @return Task|ActiveRecord[]
     */
    public function find_by($filter, $value) {
        return Task::find()
            ->where([$filter => $value])
            ->all();
    }
}