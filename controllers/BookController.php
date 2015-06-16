<?php

namespace app\controllers;

use app\models\Author;
use Yii;
use app\models\Book;
use app\models\BookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'authors' => Author::findAllAsArray()
        ]);
    }

    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderPartial('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Book model.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('accessDenied');

            return $this->goHome();
        }

        $model = new Book();

        if ($model->load(Yii::$app->request->post())) {
            if ($this->saveModel($model)) {
                return $this->goHome();
            }
        }

        return $this->render('create', [
            'model' => $model,
            'authors' => Author::findAllAsArray()
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('accessDenied');

            return $this->goHome();
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->date_update = (new \DateTime())->format('Y-m-d');
            $this->saveModel($model);

            return $this->goHome();
        } else {
            return $this->render('update', [
                'model' => $model,
                'authors' => Author::findAllAsArray()
            ]);
        }
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('accessDenied');
        } else {
            $this->findModel($id)->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param Book $model
     * @return bool
     */
    private function saveModel($model)
    {
        $model->image = UploadedFile::getInstance($model, 'image');
        if ($model->image) {
            $name = Yii::$app->params['uploadPath'] . $model->image->name;
            $model->preview = $name;
        }
        if ($model->save()) {
            if ($model->image) {
                $model->image->saveAs($model->preview);
            }

            return true;
        }

        return false;
    }
}
