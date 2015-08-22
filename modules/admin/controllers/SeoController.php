<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Seo;
use app\modules\admin\models\SearchSeo;
use app\modules\admin\controllers\DefaultController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\UploadedFile;
use Imagick;

/**
 * SeoController implements the CRUD actions for Seo model.
 */
class SeoController extends DefaultController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'create','delete','index','view'],
                        'roles' => ['admin'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                        $this->redirect('/');
                }
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = $this->findModel('1');
        $old_images = $model->images;

        if ($model->load(Yii::$app->request->post())) {
            $images = UploadedFile::getInstances($model, 'images');
            if ($images) {
                $images[0]->saveAs('web/upload/default/'. Yii::$app->user->identity->id . '_' . time() . '.' . $images[0]->extension);
                $model->images = Yii::$app->user->identity->id . '_' . time() . '.' . $images[0]->extension;
                if($old_images != ''){
                    unlink(__DIR__.'/../../../web/upload/default/'.$old_images);
                }
            }else{
                $model->images = $old_images;
            }
            $model->save();
            return $this->redirect(['index']);
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Seo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
