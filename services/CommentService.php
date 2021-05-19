<?php

namespace app\services;
use app\models\Comment;
use Yii;

class CommentService {
    public function addComment($task_id, $text) {
        $comment = new Comment();
        $comment->task_id = $task_id;
        if (!isset($text)) {
            $comment->text = "";
        }else {
            $comment->text = $text;
        }
        $comment->author_id = Yii::$app->user->id;
        $comment->create_date = Yii::$app->formatter->asDateTime('now', 'yyyy-MM-dd H:i:s');
        $comment->save();
    }

    public function findById($id) {
        $task = Comment::find()
            ->where(['id' => $id])
            ->one();
        return $task;
    }
}