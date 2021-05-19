<?php

use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Описание задачи "' . $task->title . '"';
$this->params['breadcrumbs'][] = $this->title;
$model->title=$task->title;
$model->type=$task->type;
$model->description=$task->description;
$model->status=$task->status;
$model->executor=$task->executor_id;
?>
<p>Ключ: <?=Html::encode($task->id)?></p>
<p>Название: <?=Html::encode($task->title)?></p>
<p>Тип: <?=Html::encode($type->name)?></p>
<p>Описание: <?=Html::encode($task->description)?></p>
<p>Автор: <?=Html::encode($author->login)?></p>
<p>Исполнитель: <?=Html::encode($executor->login)?></p>
<p>Статус: <?=Html::encode($status->name)?></p>
<p>Дата создания: <?=Html::encode($task->create_date)?></p>


<?php
Modal::begin([
    'header' => '<h2>Редактирование задачи</h2>',
    'toggleButton' => [
        'label' => 'Редактировать эту задачу',
        'tag' => 'button',
        'class' => 'btn btn-success change-btn',
    ]
]);
?>

<?php $form = ActiveForm::begin(['id' => 'task-form']); ?>

    <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(
        ArrayHelper::map($types, 'id', 'name')
    ) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'executor')->dropDownList(
        ArrayHelper::map($users, 'id', 'login')
    ) ?>
    <?= $form->field($model, 'status')->dropDownList(
        ArrayHelper::map($statuses, 'id', 'name')
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить изменения', ['class' => 'btn btn-primary', 'name' => 'upd-button']) ?>
    </div>
    <div class="form-group">
        <a href="site/delete-task?id=<?=$task->id?>"><button class="btn btn-danger">Удалить задачу</button></a>
    </div>

<?php ActiveForm::end(); ?>