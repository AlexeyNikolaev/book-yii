<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;

\yii\bootstrap\Modal::begin([
    'id' => 'modal-w'
]);
\yii\bootstrap\Modal::end();

?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('accessDenied')): ?>
        You do not have access to this page
    <?php endif; ?>


    <?php echo $this->render('_search', ['model' => $searchModel, 'authors' => $authors]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'preview' => [
                'attribute' => 'preview',
                'value' => function($data){
                    return Html::img($data->preview, [
                        'width' => '50px',
                        'height' => '50px',
                        'alt' => 'not set'
                    ]);
                }
            ],
            'author' => [
                'attribute' => 'author',
                'label' => 'Author'
            ],
            'date' => [
                'attribute' => 'date',
                'format' => ['date', 'php:d/m/Y']
            ],
            'date_create' => [
                'attribute' => 'date_create',
                'format' => ['date', 'php:d/m/Y']
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {view} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('Edit', $url);
                    },
                    'view' => function ($url, $model, $key) {
                        return Html::a('View', "#", [
                            'onClick' => "openModal(" . $model->id . "); return false;"
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Delete', $url, ['data-method' => 'post']);
                    },
                ]
            ],
        ],
    ]); ?>

    <p>
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>

<script type="text/javascript">
    function openModal(id) {
        $.ajax({
            method: 'POST',
            url: '?r=book/view&id=' + id,
            success: function (data) {
                jQuery("#modal-w" + " .modal-body").html(data);
                jQuery("#modal-w").modal("show");
            }
        });
    }
</script>
