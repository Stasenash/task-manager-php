<?php
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = 'Все задачи';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="site-tasks">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="flex-container">
            <p>Ключ</p>
            <p>Название</p>
            <p>Дата создания</p>
        </div>
        <?php foreach ($tasks as $task) { ?>
                <div class="flex-container">
                    <p><?=$task->id?></p>
                    <a href="/site/task-description?id=<?=$task->id?>"><?=$task->title?></a>
                    <p><?=$task->create_date?></p>
                </div>
        <?php } ?>
    </div>
<?php
    Modal::begin([
        'header' => '<h2>Добавление задачи</h2>',
        'toggleButton' => [
            'label' => 'Добавить задачу',
            'tag' => 'button',
            'class' => 'btn btn-success add-btn',
        ]
    ]);
    ?>

    <?php $form = ActiveForm::begin(['id' => 'add-task-form']); ?>

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
            <?= Html::submitButton('Создать', ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>
Modal::end();
