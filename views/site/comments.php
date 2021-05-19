<?php
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = 'Все комментарии';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-comments">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="flex-container">
        <p>Задача №</p>
        <p>Автор</p>
        <p>Текст</p>
        <p>Дата создания</p>
    </div>
    <?php foreach ($comments as $comment) { ?>
        <div class="flex-container">
            <p><?=$comment->task_id?></p>
            <p><?=$users[Yii::$app->formatter->asInteger($comment->author_id) - 1]->login?></p>
            <p><?=$comment->text?></p>
            <p><?=$comment->create_date?></p>
        </div>
    <?php } ?>
</div>