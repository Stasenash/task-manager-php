<?php

/* @var $this yii\web\View */

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Task Manager';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Поздравляем!</h1>

        <p class="lead">Теперь вы на шаг ближе к тому, чтобы пользоваться нашим трекером задач.</p>

        <p><a class="btn btn-lg btn-success" href="/site/login">Чтобы продолжить, войдите в систему</a></p>
    </div>
</div>

<?php
    Modal::begin([
        'header' => '<h2>Регистрация</h2>',
        'toggleButton' => [
            'label' => 'Зарегистрироваться',
            'tag' => 'button',
            'class' => 'btn btn-lg btn-primary reg-btn',
        ]
    ]);
?>

<?php $form = ActiveForm::begin(['id' => 'reg-form']); ?>

<?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'email')->textInput([]) ?>

<?= $form->field($model, 'password')->passwordInput([]) ?>


<div class="form-group">
    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'reg-button']) ?>
</div>


<?php ActiveForm::end(); ?>
