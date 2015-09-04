<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Article;
use app\modules\admin\models\SearchArticle;
use app\modules\admin\controllers\DefaultController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use Imagick;
use yii\helpers\Url;
/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends DefaultController
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

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {        
        $searchModel = new SearchArticle();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post())) {
            $photo = UploadedFile::getInstances($model, 'photo');
            $images = UploadedFile::getInstances($model, 'images');
            $model->url = $this->SlugHelperUrl($model->title);
            $model->created = date('Y-m-d H:i:s');
            if ($photo) {
                $photo[0]->saveAs('web/upload/article/'. Yii::$app->user->identity->id . '_' . time() . '.' . $photo[0]->extension);
                $model->photo = Yii::$app->user->identity->id . '_' . time() . '.' . $photo[0]->extension;
            }else{
                Yii::trace($photo->errors);
            }
            if ($images) {
                $images[0]->saveAs('web/upload/article/'. Yii::$app->user->identity->id . '_' . time() . '.' . $images[0]->extension);
                $model->images = Yii::$app->user->identity->id . '_im' . time() . '.' . $images[0]->extension;
            }else{
                Yii::trace($photo->errors);
            }
            if($model->photo != '' && !file_exists(__DIR__.'/../../../web/upload/300_174/300_174_'.$model->photo) && file_exists(__DIR__.'/../../../web/upload/article/'.$model->photo)){
                $thumb = new Imagick(__DIR__.'/../../../web/upload/article/'.$model->photo);
                $thumb->resizeImage(300, 174,Imagick::FILTER_LANCZOS,1);
                $thumb->writeImage(__DIR__.'/../../../web/upload/300_174/300_174_'.$model->photo);
                $thumb->destroy();
            }
            $model->save();
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_photo = $model->photo;
        $old_images = $model->images;
        if ($model->load(Yii::$app->request->post())) {
            $photo = UploadedFile::getInstances($model, 'photo');
            $images = UploadedFile::getInstances($model, 'images');

            $model->url = $this->SlugHelperUrl($model->title);
            //$model->created = date('Y-m-d H:i:s');
            if ($photo) {
                $photo[0]->saveAs('web/upload/article/'. Yii::$app->user->identity->id . '_' . time() . '.' . $photo[0]->extension);
                $model->photo = Yii::$app->user->identity->id . '_' . time() . '.' . $photo[0]->extension;

                if(isset($old_photo)){
                    if(file_exists(__DIR__.'/../../../web/upload/article/'.$old_photo)){
                    unlink(__DIR__.'/../../../web/upload/article/'.$old_photo);}
                    if(file_exists(__DIR__.'/../../../web/upload/300_174/300_174_'.$old_photo)){
                        unlink(__DIR__.'/../../../web/upload/300_174/300_174_'.$old_photo);
                    }
                }
            }else{
                $model->photo = $old_photo;
            }
            if ($images) {
                $images[0]->saveAs('web/upload/article/'. Yii::$app->user->identity->id . '_' . time() . '.' . $images[0]->extension);
                $model->images = Yii::$app->user->identity->id . '_im' . time() . '.' . $images[0]->extension;
                if($old_images != ''){
                    if(file_exists(__DIR__.'/../../../web/upload/article/'.$old_photo)) {
                        unlink(__DIR__ . '/../../../web/upload/article/' . $old_images);
                    }
                }
            }else{
                $model->images = $old_images;
            }
            if($model->photo != '' && !file_exists(__DIR__.'/../../../web/upload/300_174/300_174_'.$model->photo) && file_exists(__DIR__.'/../../../web/upload/article/'.$model->photo)){
                $thumb = new Imagick(__DIR__.'/../../../web/upload/article/'.$model->photo);
                $thumb->resizeImage(300, 174,Imagick::FILTER_LANCZOS,1);
                $thumb->writeImage(__DIR__.'/../../../web/upload/300_174/300_174_'.$model->photo);
                $thumb->destroy();
            }
            $model->save();
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
