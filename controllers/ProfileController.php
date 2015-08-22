<?php
namespace app\controllers;

use app\models\ChangePasswordForm; 
use app\models\User;
use app\models\Profile;
use app\models\Story;
use app\models\Vote;
use app\models\StoryForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use Yii;
use app\components\AlertWidget;
use Imagick;

class ProfileController extends Controller
{
    public $_profile;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
 
    public function actionIndex()
    {
        if(!Yii::$app->user->identity){
            return $this->goHome();
        }
        $profile = new Profile();
        $this->_profile = $profile->getProfile();

        /*if(Yii::$app->user->identity->status == User::STATUS_WAIT){
            return $this->goHome();
        } else*/if(Yii::$app->user->identity->status == User::STATUS_BLOCKED){
            return $this->goHome();
        }

        \Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => '']);


        return $this->render('index', [
            'model' => $this->findModel(),
            '_profile' => $this->_profile,
        ]);
    }


    private function findModel()
    {
        return User::findOne(Yii::$app->user->identity->getId());
    }

    public function actionUpdate()
    {
        $model = $this->findModel();
        $model->scenario = User::SCENARIO_PROFILE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionChangePassword()
    {
        $user = $this->findModel();
        $model = new ChangePasswordForm($user);
 
        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('changePassword', [
                'model' => $model,
            ]);
        }
    }
}
?>