<?php

namespace app\controllers;

use app\models\AddTaskForm;
use app\models\RegistrationForm;
use app\models\Status;
use app\models\Task;
use app\models\Type;
use app\models\User;
use app\models\Comment;
use app\rabbitmq\Sender;
use app\services\CommentService;
use app\services\StatusService;
use app\services\TaskService;
use app\services\TypeService;
use app\services\UserService;
use app\rabbitmq\MessagingJob;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'tasks','task-description'],
                'rules' => [
                    [
                        'actions' => ['logout', 'tasks', 'task-description'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new RegistrationForm();
        $userService = new UserService();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $userService->addUser($model->login, $model->email, $model->password);

                Yii::$app->queue->push(new MessagingJob([
                    'message' => 'Пользователь ' . $model->login . " зарегистрирован.",
                ]));

                Yii::$app->session->setFlash('success', 'Пользователь успешно зарегистрирован!');
            }
            return $this->refresh();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect("/site/tasks");
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


    /**
     * Displays tasks page.
     *
     * @return string
     */
    public function actionTasks()
    {
        $model = new AddTaskForm();

        $taskService = new TaskService();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $taskService->addTask($model->type, $model->title, $model->description,
                    $model->status, $model->executor);

                $sender = new Sender();
                $sender->sendMessage('Задача ' . $model->title . " добавлена.");

                Yii::$app->session->setFlash('success', 'Задача успешно добавлена!');
            }
            return $this->refresh();
        }

        $types = Type::find()->all();
        $users = User::find()->all();
        $statuses = Status::find()->all();

        $tasks = Task::find()->all();

        return $this->render('tasks', [
            'model' => $model,
            'types' => $types,
            'users' => $users,
            'statuses' => $statuses,
            'tasks' => $tasks
        ]);
    }

    /**
     * Displays task description page.
     *
     * @return string
     */
    public function actionTaskDescription()
    {
        $model = new AddTaskForm();

        $id = Yii::$app->request->get('id');
        $taskService = new TaskService();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $taskService->updateTask($id, $model->type, $model->title, $model->description,
                    $model->status, $model->executor);

                $sender = new Sender();
                $sender->sendMessage('Задача ' . $id . " обновлена.");

                Yii::$app->session->setFlash('success', 'Задача успешно обновлена!');
            }
            return $this->refresh();
        }

        if (!$id || !$taskService->findById($id)) {
            return $this->render('error');
        }

        $userService = new UserService();
        $typeService = new TypeService();
        $statusService = new StatusService();

        $task = $taskService->findById($id);
        $author = $userService->findById($task->author_id);
        $executor = $userService->findById($task->executor_id);
        $type = $typeService->findById($task->type);
        $status = $statusService->findById($task->status);

        $types = Type::find()->all();
        $users = User::find()->all();
        $statuses = Status::find()->all();

        return $this->render('task-description', [
            'model' => $model,
            'task'=> $task,
            'author'=> $author,
            'executor'=> $executor,
            'type'=> $type,
            'status'=> $status,
            'types'=> $types,
            'users'=> $users,
            'statuses'=> $statuses
        ]);
    }

    /**
     * Action delete task.
     *
     * @return string
     */
    public function actionDeleteTask() {
        $model = new AddTaskForm();

        $id = Yii::$app->request->get('id');
        $taskService = new TaskService();
        $taskService->deleteTask($id);

        $sender = new Sender();
        $sender->sendMessage('Задача ' . $id . " удалена.");

        Yii::$app->session->setFlash('success', 'Задача успешно удалена!');

        $types = Type::find()->all();
        $users = User::find()->all();
        $statuses = Status::find()->all();

        $tasks = Task::find()->all();

        return $this->render('tasks', [
            'model' => $model,
            'types' => $types,
            'users' => $users,
            'statuses' => $statuses,
            'tasks' => $tasks
        ]);
    }

    /**
     * Action search task.
     *
     * @return string
     */
    public function actionTaskSearch() {
        $model = new AddTaskForm();

        $title = Yii::$app->request->get('title');
        $taskService = new TaskService();
        $tasks = $taskService->findByTitle($title);

        $types = Type::find()->all();
        $users = User::find()->all();
        $statuses = Status::find()->all();


        return $this->render('tasks', [
            'model' => $model,
            'types' => $types,
            'users' => $users,
            'statuses' => $statuses,
            'tasks' => $tasks
        ]);
    }

    /**
     * Action filter task.
     *
     * @return string
     */
    public function actionTaskFilter() {
        $model = new AddTaskForm();

        $filter = Yii::$app->request->get('filter');
        $name = Yii::$app->request->get('name');

        $taskService = new TaskService();
        $typeService = new TypeService();
        $statusService = new StatusService();

        $tasks = [];

        if ($filter == "type") {
            $type_id = $typeService->findByName($name)->id;
            $tasks = $taskService->find_by("type", $type_id);
        }else if ($filter == "status") {
            $status_id = $statusService->findByName($name)->id;
            $tasks = $taskService->find_by("status", $status_id);
        }else if ($filter == "author") {
            $user_id = User::findByUsername($name)->id;
            $tasks = $taskService->find_by("author_id", $user_id);
        }else if ($filter == "executor") {
            $user_id = User::findByUsername($name)->id;
            $tasks = $taskService->find_by("executor_id", $user_id);
        }

        $types = Type::find()->all();
        $users = User::find()->all();
        $statuses = Status::find()->all();


        return $this->render('tasks', [
            'model' => $model,
            'types' => $types,
            'users' => $users,
            'statuses' => $statuses,
            'tasks' => $tasks
        ]);
    }

    /**
     * Action add comment.
     *
     * @return string
     */
    public function actionAddComment()
    {
        $model = new AddTaskForm();

        $id = Yii::$app->request->get('id');
        $text = Yii::$app->request->get('text');

        $commentService = new CommentService();
        $taskService = new TaskService();

        if (!$id || !$taskService->findById($id)) {
            return $this->render('error');
        }
        $commentService->addComment($id, $text);

        $sender = new Sender();
        $sender->sendMessage('К задаче ' . $id . " добавлен комментарий.");

        Yii::$app->session->setFlash('success', 'Комментарий успешно добавлен!');

        $userService = new UserService();
        $typeService = new TypeService();
        $statusService = new StatusService();

        $task = $taskService->findById($id);
        $author = $userService->findById($task->author_id);
        $executor = $userService->findById($task->executor_id);
        $type = $typeService->findById($task->type);
        $status = $statusService->findById($task->status);

        $types = Type::find()->all();
        $users = User::find()->all();
        $statuses = Status::find()->all();

        return $this->render('task-description', [
            'model' => $model,
            'task'=> $task,
            'author'=> $author,
            'executor'=> $executor,
            'type'=> $type,
            'status'=> $status,
            'types'=> $types,
            'users'=> $users,
            'statuses'=> $statuses
        ]);
    }

    /**
     * Displays all comments.
     *
     * @return string
     */
    public function actionComments()
    {
        $comments = Comment::find()->all();

        $users = User::find()->all();

        return $this->render('comments', [
            'comments' => $comments,
            'users' => $users,
        ]);
    }
}
