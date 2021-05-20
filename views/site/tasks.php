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
    <input id="search" name="search" type="text" placeholder="Поиск по названию">
    <script>
        function search_by_title() {
            var title = document.getElementById("search").value;
            window.location.replace("/site/task-search?title=" + title);
        }

        function filter_by(filter) {
            console.log(filter);
            var name = document.getElementById(filter).value;
            console.log(name);
            window.location.replace("/site/task-filter?filter=" + filter + "&name=" + name);
        }
    </script>
    <button class="btn btn-primary" onclick="search_by_title()">Поиск</button>
    <select id="type" onchange="filter_by('type')">
        <option>Тип</option>
        <?php foreach ($types as $type) { ?>
            <option><?=$type->name?></option>
        <?php } ?>
    </select>

    <select id="status" onchange="filter_by('status')">
        <option>Статус</option>
        <?php foreach ($statuses as $status) { ?>
            <option><?=$status->name?></option>
        <?php } ?>
    </select>

    <select id="author" onchange="filter_by('author')">
        <option>Автор</option>
        <?php foreach ($users as $user) { ?>
            <option><?=$user->login?></option>
        <?php } ?>
    </select>

    <select id="executor" onchange="filter_by('executor')">
        <option>Исполнитель</option>
        <?php foreach ($users as $user) { ?>
            <option><?=$user->login?></option>
        <?php } ?>
    </select>

    <div class="site-tasks">
        <h1><?= Html::encode($this->title) ?></h1>
        <table class="table-container">
            <tr><th>Ключ</th>
            <th>Тип</th>
            <th>Название</th>
            <th>Автор</th>
            <th>Исполнитель</th>
            <th>Статус</th>
            <th>Дата создания</th></tr>
<!--        </table>-->
        <?php foreach ($tasks as $task) { ?>
            <tr><td><?=$task->id?></td>
            <td><?=$types[$task->type - 1]->name?></td>
            <td><a href="/site/task-description?id=<?=$task->id?>"><?=$task->title?></a></td>
            <td><?=$users[$task->author_id - 1]->login?></td>
            <td><?=$users[$task->executor_id - 1]->login?></td>
            <td><?=$statuses[$task->status - 1]->name?></td>
            <td><?=$task->create_date?></td></tr
        <?php } ?>
        </table>
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
