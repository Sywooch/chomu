<?php

namespace app\controllers;

use app\models\Subscribes;
use Yii;
use yii\filters\AccessControl;
use yii\captcha\CaptchaAction;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ConfirmEmailForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\Content;
use app\models\Seo;
use app\models\TokenForm;
use app\models\Article;
use app\models\Upload;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use app\models\User;
use app\models\Vote;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\web\Session;
use Imagick;
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\VarDumper;
use yii\helpers\Url;
use yii\web\UploadedFile;
use app\models\Yes;
use app\models\No;
use app\models\Questions;
use yii\swiftmailer;

class SiteController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
            'eauth' => [
                // required to disable csrf validation on OpenID requests
                'class' => \nodge\eauth\openid\ControllerBehavior::className(),
                'only' => array('login'),
            ],
        ];
    }

    public function actions()
    {
        return [
            /* 'error' => [
              'class' => 'yii\web\ErrorAction',
              ], */
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'transparent' => true,
                'minLength' => 3,
                'maxLength' => 4
            ],
        ];
    }

    public function actionError()
    {
        return $this->redirect('/');
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['result']);
        }
        $this->layout = 'main';
        $this->getMetaTagsDefault();

        $session = new Session;
        //var_dump(Yii::$app->session->get('q'));

        $yes = new Yes;
        $no = new No;

        $questionsYes = Questions::find()->andWhere(['yes' => 1])->all();
        $questionsNo = Questions::find()->andWhere(['no' => 1])->all();

        $signupModel = new SignupForm();
        if (Yii::$app->request->isAjax && $signupModel->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($signupModel);
        }
        if ($signupModel->load(Yii::$app->request->post())) {
            if ($user = $signupModel->signup()) {
                $session = new Session;
                $session->open();
                Yii::$app->session->set('email_user', $user->email);
                Yii::$app->session->set('email_confirm_token', $user->email_confirm_token);
                Yii::$app->session->set('block', 'true');
                return $this->redirect('/');
            }
        }
//        print_r($signupModel);
        return $this->render('index', [
            'yes' => $yes,
            'no' => $no,
            'questionsYes' => $questionsYes,
            'questionsNo' => $questionsNo,
            'signupModel' => $signupModel
        ]);
    }

    public function actionTestParam()
    {
        echo '<pre>';
        print_r(Yii::$app->user->identity->getProfile()->one());
        //echo Yii::$app->user->getProfile();
        //print_r($_GET);
        //die();
    }

    public function actionSocialLogin()
    {

        $serviceName = Yii::$app->getRequest()->get('service');

        if (isset($serviceName)) {
            /** @var $eauth \nodge\eauth\ServiceBase */
            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);
            $eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
            $eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('site/login'));

            try {
                if ($eauth->authenticate()) {
//                  var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes()); exit;

                    $identity = User::findByEAuth($eauth);
                    Yii::$app->getUser()->login($identity);

                    Vote::processVote();

                    // special redirect with closing popup window
                    //$eauth->redirect(Yii::$app->request->referrer);
                    $eauth->redirect(Yii::$app->getUrlManager()->createAbsoluteUrl('thanks.html'));
                } else {
                    // close popup window and redirect to cancelUrl
                    $eauth->cancel();
                }

                //return $this->redirect('/');
                return $this->redirect(Yii::$app->request->referrer);
            } catch (\nodge\eauth\ErrorException $e) {
                // save error to show it later
                Yii::$app->getSession()->setFlash('error', 'EAuthException: ' . $e->getMessage());

                // close popup window and redirect to cancelUrl
//              $eauth->cancel();
                $eauth->redirect($eauth->getCancelUrl());
            }
        }
    }

    public function actionLogin()
    {

        $this->layout = 'admin';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $us = new User();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->identity->role == 2) {
                return $this->redirect('/admin/index');
                //return $this->redirect(Yii::$app->request->referrer);
            } else {
                return $this->redirect(Yii::$app->request->referrer);
            }
        } /* else {
          return $this->redirect('@web/');

          } */
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(Yii::$app->request->referrer);
    }


    public function actionSignup()
    {
        $this->layout = false;
        $model = new SignupForm();

        $post = Yii::$app->request->post();
        $model->email = $post['email'];
        $model->password = $post['password'];
        $model->name = $post['name'];

        if ($user = $model->signup()) {
            $session = new Session;
            $session->open();
            Yii::$app->session->set('email_user', $user->email);
            Yii::$app->session->set('email_confirm_token', $user->email_confirm_token);
            Yii::$app->session->set('block', 'true');
            $this->send($user->email, $user->email_confirm_token);
            return $this->render('send', [
                'model' => $model,
                'post' => Yii::$app->request->post()
            ]);
        }


        return $this->render('send', [
            'model' => $model,
           // 'token' => $user->email_confirm_token
        ]);

    }

    public function send($email, $token)
    {

       
        Yii::$app->mailer->compose()

            ->setFrom('welcome@chomu.net')
            ->setTo($email)
            ->setSubject('Email confirmation for ' . Yii::$app->name)
            ->setTextBody('Plain text content')
            ->setHtmlBody('<b>HTML content</b>' . $token)
            ->send();

    }

    public function actionToken()
    {
        $model = new TokenForm();
        $us = new User();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->set('block', 'false');
            return $this->redirect(['profile/index']);
        } else {
            return $this->redirect('@web/');
        }
    }

    public function actionAbout()
    {
        $model = Content::find()->where(['id' => 1])->one();

        \Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $model->name]);
        $this->getMetaTagsDefault();
        return $this->render('about', [
            'model' => $model,
        ]);
    }

    public function actionVote()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            //print_r($_POST);

            $session = new Session;
            $session->open();
            Yii::$app->session->set('question_id', $_POST['id']);

            if (!empty($_POST['answer'])) {
                Yii::$app->session->set('answer', strip_tags($_POST['answer']));
            }

            $result = array(
                'success' => true,
            );

            return $result;
            Yii::app()->end();
        }
    }

    public function actionSession()
    {
        //echo Yii::$app->getUrlManager()->createAbsoluteUrl('thanks.html');
        //$session = new Session;
        //       $session->open();
        echo '<pre>';
        // print_r(Yii::$app->session);
        //   print_r($_SESSION);
        //echo Yii::$app->session->get('question_id');
        //$d = Yii::$app->user->identity->social_id;
        //$user = User::findOne(['social_id' => Yii::$app->user->identity->social_id]);
        //print_r($user); die();
    }

    public function actionResult()
    {

        if (!Yii::$app->user->identity) {
            return $this->goHome();
        }

        \Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => '']);
        $this->getMetaTagsDefault();

        $questionsYes = Questions::find()->andWhere(['yes' => 1])->all();
        $questionsNo = Questions::find()->andWhere(['no' => 1])->all();

        $customYes = new Questions();
        $customYes->id = 1000001;
        $customYes->questions = 'Iншi';
        $customYes->yes = 1;
        $questionsYes[] = $customYes;

        $customNo = new Questions();
        $customNo->id = 1000002;
        $customNo->questions = 'Iншi';
        $customNo->no = 1;
        $questionsNo[] = $customNo;

        $result = Vote::getResult();

        return $this->render('result', [
            'questionsYes' => $questionsYes,
            'questionsNo' => $questionsNo,
            'result' => $result
        ]);
    }

    public function actionNews()
    {
        if (Yii::$app->request->get('url')) {

            $url = Html::encode(Yii::$app->request->get('url'));
            $new = Article::find()->where(['status' => 1, 'url' => $url])->one();

            \Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $new->keywords]);
            \Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $new->description]);


            \Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => 'http://' . Yii::$app->request->getServerName() . Url::to(['site/news', 'url' => isset($new->url)
                    ? $new->url : null])]);
            \Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $new->title]);
            \Yii::$app->view->registerMetaTag(['property' => 'og:type', 'content' => 'article']);
            \Yii::$app->view->registerMetaTag(['property' => 'og:description', 'content' => $new->pre_content]);
            \Yii::$app->view->registerMetaTag(['property' => 'og:image', 'content' => 'http://' . Yii::$app->request->getServerName() . '/web/upload/article/' . $new->photo]);
            \Yii::$app->view->registerMetaTag(['property' => 'og:site_name', 'content' => '']);

            $arrow = $this->arrow($new->id);
            return $this->render('news', [
                'new' => $new,
                'arrow' => $arrow,
                'p' => '???'
            ]);
        } else {

            \Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => '']);
            $this->getMetaTagsDefault();

            $news = Article::find()->where(['status' => 1]);
            $news = $news->all();

            return $this->render('news', [
                'news' => $news,
            ]);
        }
    }

    public function arrow($data)
    {
        if (isset($data) && $data != null) {

            $next = Yii::$app->db->createCommand("SELECT * FROM {{article}} WHERE id > '{$data}' ORDER BY id LIMIT 1")->queryOne();
            $prev = Yii::$app->db->createCommand("SELECT * FROM {{article}} WHERE id < '{$data}' ORDER BY id DESC LIMIT 1")->queryOne();

            return $arr = [
                'next' => $next,
                'prev' => $prev,
            ];
        } else return false;
    }

    public function actionConfirmEmail($token)
    {
        try {
            $model = new ConfirmEmailForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->confirmEmail()) {
            Yii::$app->getSession()->setFlash('success', 'Спасибо! Ваш Email успешно подтверждён.');
        } else {
            Yii::$app->getSession()->setFlash('error', 'Ошибка подтверждения Email.');
        }

        return $this->goHome();
    }

    public function actionReset()
    {
        $model = new PasswordResetRequestForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (isset($model)) {
                $user = User::findOne([
                    'status' => User::STATUS_ACTIVE,
                    'email' => $model->email,
                ]);
                if ($user) {
                    $password_hash = $user->generate_password();
                    $user->setPassword($password_hash);
                    if ($user->save()) {
                        Yii::$app->mailer->compose('passwordResetToken', ['password_hash' => $password_hash])
                            ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
                            ->setTo($model->email)
                            ->setSubject('Відновлення пароля для ' . Yii::$app->name)
                            ->send();
                    }
                }
                Yii::$app->getSession()->setFlash('success_reset', 'Якщо Ви правильно вказали електронну адресу,<br />то на неї Вам було відправлено пароль');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('success_reset', 'Вибачте. У нас виникли проблеми з відправкою.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'Спасибо! Пароль успешно изменён.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function getMetaTagsDefault($false = null)
    {

        $seo = Seo::find()->where(['id' => 1])->one();
        if ($false !== false) {
            \Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => isset($seo)
            && $seo !== null ? $seo->keywords : '']);
            \Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => isset($seo)
            && $seo !== null ? $seo->keywords : '']);

            \Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => 'http://' . Yii::$app->request->getServerName()]);
            \Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $seo->title]);
            \Yii::$app->view->registerMetaTag(['property' => 'og:description', 'content' => $seo->description]);
            \Yii::$app->view->registerMetaTag(['property' => 'og:image', 'content' => 'http://' . Yii::$app->request->getServerName() . '/web/upload/default/' . $seo->images]);
            \Yii::$app->view->registerMetaTag(['property' => 'og:site_name', 'content' => $seo->title]);
        }

        return true;
    }

    public function actionThanks()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $profile = Yii::$app->user->identity->getProfile()->one();

        return $this->render('thanks', [
            'profile' => $profile
        ]);
    }

    public function beforeAction($action)
    {

        if (parent::beforeAction($action)) {

            $this->subscribes();

            return true;
        }

        return false;
    }

    public function subscribes()
    {
        $email = (\Yii::$app->request->get('subscribe_email'));

        if (isset($email)) {

            $key = md5(microtime());

            $subscribes = new Subscribes();
            $subscribes->email = $email;
            $subscribes->key = $key;
            $subscribes->status = 0;
            if ($subscribes->save()) {


                $link = $_SERVER['SERVER_NAME'] . '/?confirm=' . $key;

//                $message = 'hello your link <a href="http://' . $link . '">' . $link . '</a>';
//
//                Yii::$app->mailer->compose()
//                    ->setFrom('chomu.net@gmail.com')
//                    ->setTo($email)
//                    ->setSubject('Confirmation subscribes')
//                    ->setHtmlBody($message)
//                    ->send();

                \Yii::$app->getSession()->setFlash('subscribe_success', 'Дякуємо! Ваш email додано до нашої розсилки');
            } else {
                \Yii::$app->getSession()->setFlash('subscribe_error', $subscribes->errors['email']['0']);
            }
        }

        $confirm = (\Yii::$app->request->get('confirm'));

        if (isset($confirm)) {
            $model = Subscribes::findOne(['key' => $confirm]);
            $model->status = 1;
            $model->save();
        }

        return true;

        //Yii::$app->controller->goBack();
        //Yii::$app->response->getHeaders()->set('X-Pjax-Url: ' . Yii::$app->request->referrer);
        //return $this->redirect(Yii::$app->request->referrer);
    }
}