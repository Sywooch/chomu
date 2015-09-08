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

class FixController extends Controller
{
    public $layout = false;

    public function behaviors()
    {
        return [
            'eauth' => [
                // required to disable csrf validation on OpenID requests
                'class' => \nodge\eauth\openid\ControllerBehavior::className(),
                'only'  => array('login'),
            ],
        ];
    }

    public function actionIndex()
    {
        echo 'index<br>';

        /* $session = new Session;
          $session->open();
          $session */

        return $this->render('index');
    }

    public function actionSocialLogin()
    {
        echo '<pre>socialLogin<br>';

        $serviceName = Yii::$app->getRequest()->get('service');

        if (isset($serviceName)) {
            // @var $eauth \nodge\eauth\ServiceBase
            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);

            //$eauth->fetchAttributes();
            //print_r($eauth);
            //$eauth = Yii::$app->get('eauth')->setComponents($components)
            //$eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
            //$eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('site/login'));

            try {
                if ($eauth->authenticate()) {
                    print_r($eauth->getAttributes());

//                  var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes()); exit;
                    //$id = $service->getServiceName() . '-' . $service->getId();
                    //
                    //$identity = User::findByEAuth($eauth);
                    //Yii::$app->getUser()->login($identity);
                    //Vote::processVote();
                    // special redirect with closing popup window
                    //$eauth->redirect(Yii::$app->request->referrer);
                    //$eauth->redirect(Yii::$app->getUrlManager()->createAbsoluteUrl('thanks.html'));
                    echo 'eauth->authenticate<br>';
                } else {
                    // close popup window and redirect to cancelUrl
                    echo 'eauth->cancel<br>';
                    //$eauth->cancel();
                }

                echo 'redirect(Yii::$app->request->referrer)';
                //return $this->redirect('/');
                //return $this->redirect(Yii::$app->request->referrer);
            } catch (\nodge\eauth\ErrorException $e) {
                // save error to show it later
                //Yii::$app->getSession()->setFlash('error', 'EAuthException: ' . $e->getMessage());
                // close popup window and redirect to cancelUrl
//              $eauth->cancel();
                echo 'redirect($eauth->getCancelUrl())';
                //$eauth->redirect($eauth->getCancelUrl());
            }
        }
    }

    public function actionSession()
    {
        //echo Yii::$app->getUrlManager()->createAbsoluteUrl('thanks.html');
        $session = new Session;
        $session->open();
        echo '<pre>';
        print_r($session);
        print_r($_SESSION);
        // print_r(Yii::$app->session);
        //echo Yii::$app->session->get('question_id');
        //$d = Yii::$app->user->identity->social_id;
        //$user = User::findOne(['social_id' => Yii::$app->user->identity->social_id]);
        //print_r($user); die();
    }

    public function actionTestVote()
    {
        Vote::processVote();
            /*$user = User::findOne(['social_id' => Yii::$app->user->identity->social_id]);

        $vote               = new Vote();
        $vote->user_id      = $user->id;
        $vote->questions_id = Yii::$app->session->get('question_id');
        $vote->vote         = 1;
        $vote->save();

        echo '<pre>';
        print_r($vote);
        print_r( $vote->getErrors());*/
    }
}